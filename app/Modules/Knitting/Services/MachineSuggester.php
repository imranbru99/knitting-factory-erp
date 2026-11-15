<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Services;

use App\Modules\Knitting\Models\Machine;
use Illuminate\Support\Collection;

final class MachineSuggester
{
    /**
     * @param  Collection<int, Machine>  $machines
     * @return Collection<int, Machine>
     */
    public function suggest(Collection $machines, string $machineType, float $dia, float $gauge): Collection
    {
        return $machines
            ->filter(function (Machine $machine) use ($machineType, $dia, $gauge): bool {
                if ($machine->status === 'down') {
                    return false;
                }
                if ($machine->machine_type !== $machineType) {
                    return false;
                }
                if (abs((float) $machine->dia - $dia) > 1) {
                    return false;
                }

                return abs((float) $machine->gauge - $gauge) < 0.6;
            })
            ->sortBy('code')
            ->values();
    }

    public function compatible(Machine $machine, string $machineType, float $dia, float $gauge): bool
    {
        return $this->suggest(collect([$machine]), $machineType, $dia, $gauge)->isNotEmpty();
    }
}
