<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Services;

final class CostingCalculator
{
    /**
     * @param  array{yarn_rate: float, process_loss_pct: float, wastage_pct: float, knitting_charge: float, dyeing_charge: float, overhead_pct: float, finance_pct: float, profit_pct: float, gsm?: float, width_inch?: float}  $input
     * @return array{yarn_per_kg: float, conversion_per_kg: float, cost_per_kg: float, quoted_per_kg: float, yards_per_kg: float|null, cost_per_yard: float|null}
     */
    public function quote(array $input): array
    {
        $yarnPerKg = round(
            (float) $input['yarn_rate']
            * (1 + ((float) $input['process_loss_pct'] / 100))
            * (1 + ((float) $input['wastage_pct'] / 100)),
            4,
        );
        $conversion = round((float) $input['knitting_charge'] + (float) $input['dyeing_charge'], 4);
        $withOverhead = ($yarnPerKg + $conversion) * (1 + ((float) $input['overhead_pct'] / 100));
        $cost = round($withOverhead * (1 + ((float) $input['finance_pct'] / 100)), 4);
        $quoted = round($cost * (1 + ((float) $input['profit_pct'] / 100)), 4);
        $yards = $this->yardsPerKg((float) ($input['gsm'] ?? 0), (float) ($input['width_inch'] ?? 0));

        return [
            'yarn_per_kg' => $yarnPerKg,
            'conversion_per_kg' => $conversion,
            'cost_per_kg' => $cost,
            'quoted_per_kg' => $quoted,
            'yards_per_kg' => $yards,
            'cost_per_yard' => $yards && $yards > 0 ? round($cost / $yards, 4) : null,
        ];
    }

    public function yardsPerKg(float $gsm, float $widthInch): ?float
    {
        if ($gsm <= 0 || $widthInch <= 0) {
            return null;
        }

        $widthM = $widthInch * 0.0254;
        $metersPerKg = 1000 / ($gsm * $widthM);

        return round($metersPerKg / 0.9144, 4);
    }
}
