<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Services;

final class BomCalculator
{
    /**
     * Fabric kilograms to yarn kilograms, including process loss and wastage.
     */
    public function yarnKilograms(float $fabricKg, float $ratioPercent, float $processLossPercent, float $wastagePercent): float
    {
        $factor = (1 + ($processLossPercent / 100)) * (1 + ($wastagePercent / 100)) * ($ratioPercent / 100);

        return round($fabricKg * $factor, 4);
    }
}
