<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Services;

final class OeeCalculator
{
    /**
     * @return array{availability: float, performance: float, quality: float, oee: float}
     */
    public function calculate(float $plannedMinutes, float $runMinutes, float $theoreticalKg, float $actualKg, float $goodKg): array
    {
        $availability = $plannedMinutes > 0 ? min(1, $runMinutes / $plannedMinutes) : 0;
        $performance = $theoreticalKg > 0 ? min(1.5, $actualKg / $theoreticalKg) : 0;
        $quality = $actualKg > 0 ? min(1, $goodKg / $actualKg) : 0;
        $performanceCapped = min(1, $performance);

        return [
            'availability' => round($availability, 4),
            'performance' => round($performance, 4),
            'quality' => round($quality, 4),
            'oee' => round($availability * $performanceCapped * $quality, 4),
        ];
    }
}
