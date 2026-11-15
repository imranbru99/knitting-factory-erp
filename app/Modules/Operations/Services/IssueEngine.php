<?php

declare(strict_types=1);

namespace App\Modules\Operations\Services;

use App\Modules\Operations\Models\Issue;
use App\Modules\Operations\Models\IssueEvent;
use App\Modules\Operations\Models\IssueRule;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

final class IssueEngine
{
    /**
     * @param  array<string, mixed>  $facts
     * @return array{title: string, severity: string, owner_role: string, solution: string, detail: string}|null
     */
    public function evaluate(string $key, array $facts): ?array
    {
        $rule = IssueCatalog::all()[$key] ?? null;
        if ($rule === null) {
            throw new RuntimeException('Unknown issue rule '.$key);
        }

        if (! ($rule['detect'])($facts)) {
            return null;
        }

        return [
            'title' => $rule['title'],
            'severity' => $rule['severity'],
            'owner_role' => $rule['owner_role'],
            'solution' => $rule['solution'],
            'detail' => $rule['title'].' '.json_encode($facts),
        ];
    }

    /**
     * @param  array<string, mixed>  $facts
     */
    public function raise(int $companyId, string $key, array $facts, ?Model $subject = null): ?Issue
    {
        $hit = $this->evaluate($key, $facts);
        if ($hit === null) {
            return null;
        }

        $existing = Issue::query()
            ->where('company_id', $companyId)
            ->where('rule_key', $key)
            ->where('status', 'open')
            ->when($subject, fn ($query) => $query->where('subject_type', $subject::class)->where('subject_id', $subject->getKey()))
            ->first();

        if ($existing instanceof Issue) {
            return $existing;
        }

        $stored = IssueRule::query()->where('company_id', $companyId)->where('key', $key)->first();
        $sla = (int) ($stored->sla_hours ?? IssueCatalog::all()[$key]['sla_hours']);

        $issue = Issue::query()->create([
            'company_id' => $companyId,
            'rule_key' => $key,
            'severity' => $stored->severity ?? $hit['severity'],
            'title' => $hit['title'],
            'detail' => $hit['detail'],
            'suggested_solution' => $hit['solution'],
            'owner_role' => $stored->owner_role ?? $hit['owner_role'],
            'status' => 'open',
            'sla_due_at' => now()->addHours($sla),
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'escalated_level' => 0,
        ]);

        IssueEvent::query()->create([
            'company_id' => $companyId,
            'issue_id' => $issue->id,
            'kind' => 'opened',
            'note' => $hit['detail'],
            'user_id' => auth()->id(),
        ]);

        return $issue;
    }

    public function escalateOverdue(): int
    {
        $count = 0;
        $open = Issue::query()->where('status', 'open')->where('sla_due_at', '<', now())->get();
        foreach ($open as $issue) {
            $issue->escalated_level = ((int) $issue->escalated_level) + 1;
            $issue->save();
            IssueEvent::query()->create([
                'company_id' => $issue->company_id,
                'issue_id' => $issue->id,
                'kind' => 'escalated',
                'note' => 'SLA passed',
                'user_id' => auth()->id(),
            ]);
            $count++;
        }

        return $count;
    }
}
