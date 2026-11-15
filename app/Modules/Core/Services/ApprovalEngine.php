<?php

declare(strict_types=1);

namespace App\Modules\Core\Services;

use App\Models\User;
use App\Modules\Core\Models\ApprovalActionRecord;
use App\Modules\Core\Models\ApprovalLevel;
use App\Modules\Core\Models\ApprovalRequest;
use App\Modules\Core\Models\ApprovalWorkflow;
use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class ApprovalEngine
{
    public function submit(Model $document): ApprovalRequest
    {
        if (! $document instanceof ErpModel || ! property_exists($document, 'documentType')) {
            throw new RuntimeException('Only numbered ERP documents can enter approval.');
        }

        return DB::transaction(function () use ($document): ApprovalRequest {
            $workflow = ApprovalWorkflow::query()
                ->where('company_id', $document->company_id)
                ->where('doc_type', $document->documentType)
                ->where('is_active', true)
                ->first();

            if (! $workflow instanceof ApprovalWorkflow) {
                $document->markStatus('approved');

                return ApprovalRequest::query()->create([
                    'company_id' => $document->company_id,
                    'approval_workflow_id' => null,
                    'approvable_type' => $document::class,
                    'approvable_id' => $document->getKey(),
                    'status' => 'approved',
                    'current_level' => 0,
                    'submitted_by' => auth()->id(),
                ]);
            }

            $first = $workflow->levels()->orderBy('level')->first();
            $document->markStatus('pending');

            return ApprovalRequest::query()->create([
                'company_id' => $document->company_id,
                'approval_workflow_id' => $workflow->id,
                'approvable_type' => $document::class,
                'approvable_id' => $document->getKey(),
                'status' => 'pending',
                'current_level' => $first?->level ?? 1,
                'submitted_by' => auth()->id(),
            ]);
        });
    }

    public function approve(ApprovalRequest $request, User $user, ?string $comment = null): ApprovalRequest
    {
        return DB::transaction(function () use ($request, $user, $comment): ApprovalRequest {
            $request = ApprovalRequest::query()->whereKey($request->id)->lockForUpdate()->firstOrFail();
            if ($request->status !== 'pending') {
                throw new RuntimeException('This approval is already finished.');
            }

            $this->assertCanAct($request, $user);
            $this->record($request, $user, 'approved', $comment);
            $next = $this->nextLevel($request);

            if ($next instanceof ApprovalLevel) {
                $request->current_level = $next->level;
                $request->save();

                return $request;
            }

            $document = $this->document($request);
            $document->markStatus('approved');
            $request->status = 'approved';
            $request->save();

            return $request;
        });
    }

    public function reject(ApprovalRequest $request, User $user, string $comment): ApprovalRequest
    {
        return DB::transaction(function () use ($request, $user, $comment): ApprovalRequest {
            $request = ApprovalRequest::query()->whereKey($request->id)->lockForUpdate()->firstOrFail();
            if ($request->status !== 'pending') {
                throw new RuntimeException('This approval is already finished.');
            }

            $this->assertCanAct($request, $user);
            $this->record($request, $user, 'rejected', $comment);
            $document = $this->document($request);
            $document->markStatus('rejected');
            $request->status = 'rejected';
            $request->save();

            return $request;
        });
    }

    public function escalateTimedOut(): int
    {
        $count = 0;
        $pending = ApprovalRequest::query()->where('status', 'pending')->whereNotNull('approval_workflow_id')->get();

        foreach ($pending as $request) {
            $level = ApprovalLevel::query()
                ->where('approval_workflow_id', $request->approval_workflow_id)
                ->where('level', $request->current_level)
                ->first();

            if (! $level instanceof ApprovalLevel || $level->timeout_hours === null) {
                continue;
            }

            $due = $request->updated_at?->copy()->addHours((int) $level->timeout_hours);
            if ($due === null || $due->isFuture()) {
                continue;
            }

            $next = $this->nextLevel($request);
            $this->record($request, null, 'escalated', 'Timed out at level '.$request->current_level);
            if ($next instanceof ApprovalLevel) {
                $request->current_level = $next->level;
                $request->save();
            }
            $count++;
        }

        return $count;
    }

    private function assertCanAct(ApprovalRequest $request, User $user): void
    {
        if ($user->is_super_admin || $request->approval_workflow_id === null) {
            return;
        }

        $level = ApprovalLevel::query()
            ->where('approval_workflow_id', $request->approval_workflow_id)
            ->where('level', $request->current_level)
            ->first();

        if (! $level instanceof ApprovalLevel) {
            return;
        }

        $slugs = $user->roles()->pluck('slug')->all();
        if (! in_array($level->role_slug, $slugs, true)) {
            throw new RuntimeException('This user cannot approve the current level.');
        }
    }

    private function nextLevel(ApprovalRequest $request): ?ApprovalLevel
    {
        if ($request->approval_workflow_id === null) {
            return null;
        }

        return ApprovalLevel::query()
            ->where('approval_workflow_id', $request->approval_workflow_id)
            ->where('level', '>', (int) $request->current_level)
            ->orderBy('level')
            ->first();
    }

    private function document(ApprovalRequest $request): ErpModel
    {
        $class = $request->approvable_type;
        $document = $class::query()->find($request->approvable_id);
        if (! $document instanceof ErpModel) {
            throw new RuntimeException('Approval document is missing.');
        }

        return $document;
    }

    private function record(ApprovalRequest $request, ?User $user, string $decision, ?string $comment): void
    {
        ApprovalActionRecord::query()->create([
            'company_id' => $request->company_id,
            'approval_request_id' => $request->id,
            'level' => $request->current_level,
            'user_id' => $user?->id,
            'decision' => $decision,
            'comment' => $comment,
            'acted_at' => now(),
        ]);
    }
}
