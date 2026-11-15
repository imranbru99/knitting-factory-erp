<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Services;

/**
 * Factory payroll using a 208-hour month and double-rate overtime,
 * the usual Bangladesh knit-floor practice under the Labour Act.
 */
final class PayrollCalculator
{
    /**
     * @param  array{basic: float, house_rent: float, medical: float, conveyance: float, attendance_bonus: float, absent_days: float, ot_hours: float, advance: float, loan_installment: float, tax: float, festival_bonus?: float}  $input
     * @return array{gross: float, ot: float, bonus: float, deductions: float, net: float}
     */
    public function calculate(array $input): array
    {
        $basic = (float) $input['basic'];
        $allowances = (float) $input['house_rent'] + (float) $input['medical'] + (float) $input['conveyance'];
        $hourly = $basic > 0 ? $basic / 208 : 0;
        $ot = round($hourly * 2 * (float) $input['ot_hours'], 2);
        $bonus = (float) $input['absent_days'] > 0 ? 0.0 : (float) $input['attendance_bonus'];
        $festival = (float) ($input['festival_bonus'] ?? 0);
        $gross = round($basic + $allowances + $ot + $bonus + $festival, 2);
        $deductions = round((float) $input['advance'] + (float) $input['loan_installment'] + (float) $input['tax'], 2);

        return [
            'gross' => $gross,
            'ot' => $ot,
            'bonus' => $bonus,
            'deductions' => $deductions,
            'net' => round($gross - $deductions, 2),
        ];
    }
}
