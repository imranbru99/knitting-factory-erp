<?php

use App\Models\User;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Models\Unit;
use App\Modules\Support\CompanyContext;
use App\Modules\Support\KnitCycle;

it('reconciles the demo order from yarn receipt to buyer collection', function () {
    $company = Company::query()->create([
        'code' => 'GK',
        'name' => 'Gazipur Knit',
        'default_currency' => 'BDT',
        'timezone' => 'Asia/Dhaka',
    ]);
    $unit = Unit::query()->create([
        'company_id' => $company->id,
        'code' => 'U1',
        'name' => 'Tongi',
        'type' => 'factory',
    ]);
    $user = User::factory()->create([
        'company_id' => $company->id,
        'unit_id' => $unit->id,
        'is_super_admin' => true,
    ]);
    $this->actingAs($user);
    CompanyContext::set($company->id, $unit->id);

    $result = app(KnitCycle::class)->run($company, $unit);

    expect($result['yarn_kg'])->toEqual(1050.6);
    expect($result['yarn_value'])->toEqual(472770.0);
    expect($result['grey_kg'])->toEqual(980.0);
    expect($result['finished_kg'])->toEqual(950.0);
    expect($result['invoice_subtotal'])->toEqual(617500.0);
    expect($result['vat'])->toEqual(92625.0);
    expect($result['invoice_total'])->toEqual(710125.0);
    expect($result['yarn_on_hand'])->toEqual(0.0);
    expect($result['grey_on_hand'])->toEqual(0.0);
    expect($result['finished_on_hand'])->toEqual(0.0);
    expect($result['yarn_gl'])->toEqual(0.0);
    expect($result['grey_gl'])->toEqual(0.0);
    expect($result['finished_gl'])->toEqual(0.0);
    expect($result['ar_balance'])->toEqual(0.0);
    expect($result['journal_difference'])->toEqual(0.0);
});
