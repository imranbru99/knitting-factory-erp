<?php

declare(strict_types=1);

namespace App\Modules\Quality\Services;

final class FourPointGrader
{
    public function pointsPerHundredSquareYards(float $totalPoints, float $lengthYards, float $widthInches): float
    {
        if ($lengthYards <= 0 || $widthInches <= 0) {
            return 0.0;
        }

        return round(($totalPoints * 3600) / ($lengthYards * $widthInches), 2);
    }

    public function grade(float $pointsPerHundred): string
    {
        return match (true) {
            $pointsPerHundred <= 20 => 'A',
            $pointsPerHundred <= 28 => 'B',
            $pointsPerHundred <= 40 => 'C',
            default => 'Reject',
        };
    }
}
