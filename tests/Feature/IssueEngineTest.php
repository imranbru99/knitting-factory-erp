<?php

use App\Models\User;
use App\Modules\Core\Models\Company;
use App\Modules\Operations\Models\Issue;
use App\Modules\Operations\Services\IssueCatalog;
use App\Modules\Operations\Services\IssueEngine;
use App\Modules\Support\CompanyContext;

it('fires each factory issue rule and stays quiet on a clean fact', function () {
    expect(IssueCatalog::keys())->toHaveCount(25);

    $engine = app(IssueEngine::class);
    foreach (IssueCatalog::all() as $key => $rule) {
        expect($engine->evaluate($key, $rule['positive']))->not->toBeNull();
        expect($engine->evaluate($key, $rule['negative']))->toBeNull();
    }
});

it('stores an open issue and escalates it after the SLA', function () {
    $company = Company::query()->create([
        'code' => 'GK',
        'name' => 'Gazipur Knit',
        'default_currency' => 'BDT',
        'timezone' => 'Asia/Dhaka',
    ]);
    $user = User::factory()->create(['company_id' => $company->id, 'is_super_admin' => true]);
    $this->actingAs($user);
    CompanyContext::set($company->id);

    $issue = app(IssueEngine::class)->raise($company->id, 'gsm_out', ['gsm' => 190, 'min' => 155, 'max' => 165]);

    expect($issue)->toBeInstanceOf(Issue::class);
    expect($issue->status)->toBe('open');

    $issue->sla_due_at = now()->subHour();
    $issue->save();

    expect(app(IssueEngine::class)->escalateOverdue())->toBe(1);
    expect($issue->fresh()->escalated_level)->toBe(1);
});
