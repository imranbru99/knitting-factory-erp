<?php

use App\Modules\Commercial\Services\BomCalculator;
use App\Modules\Commercial\Services\CostingCalculator;
use App\Modules\HumanResources\Services\PayrollCalculator;
use App\Modules\Knitting\Services\OeeCalculator;
use App\Modules\Quality\Services\FourPointGrader;

it('turns fabric kilograms into yarn with loss and wastage', function () {
    expect(app(BomCalculator::class)->yarnKilograms(1000, 100, 3, 2))->toBe(1050.6);
});

it('prices a fabric kilogram and a yard', function () {
    $quote = app(CostingCalculator::class)->quote([
        'yarn_rate' => 450,
        'process_loss_pct' => 3,
        'wastage_pct' => 2,
        'knitting_charge' => 35,
        'dyeing_charge' => 80,
        'overhead_pct' => 5,
        'finance_pct' => 2,
        'profit_pct' => 8,
        'gsm' => 160,
        'width_inch' => 60,
    ]);

    expect($quote['yarn_per_kg'])->toBe(472.77);
    expect($quote['quoted_per_kg'])->toBeGreaterThan($quote['cost_per_kg']);
    expect($quote['yards_per_kg'])->not->toBeNull();
});

it('grades a roll on the four-point scale', function () {
    $grader = app(FourPointGrader::class);
    $points = $grader->pointsPerHundredSquareYards(20, 100, 36);

    expect($points)->toBe(20.0);
    expect($grader->grade($points))->toBe('A');
    expect($grader->grade(50))->toBe('Reject');
});

it('calculates machine OEE from time, output, and good fabric', function () {
    $oee = app(OeeCalculator::class)->calculate(480, 400, 280, 250, 240);

    expect($oee['oee'])->toBeGreaterThan(0);
    expect($oee['oee'])->toBeLessThan(1);
});

it('pays double overtime and withholds the attendance bonus after an absence', function () {
    $pay = app(PayrollCalculator::class);
    $present = $pay->calculate([
        'basic' => 20800, 'house_rent' => 8000, 'medical' => 1000, 'conveyance' => 500,
        'attendance_bonus' => 500, 'absent_days' => 0, 'ot_hours' => 2, 'advance' => 0,
        'loan_installment' => 0, 'tax' => 0,
    ]);
    $absent = $pay->calculate([
        'basic' => 20800, 'house_rent' => 0, 'medical' => 0, 'conveyance' => 0,
        'attendance_bonus' => 500, 'absent_days' => 1, 'ot_hours' => 0, 'advance' => 0,
        'loan_installment' => 0, 'tax' => 0,
    ]);

    expect($present['ot'])->toBe(400.0);
    expect($present['bonus'])->toBe(500.0);
    expect($absent['bonus'])->toBe(0.0);
});
