<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Models\User;

final class CompanyContext
{
    private static ?int $companyId = null;

    private static ?int $unitId = null;

    private static bool $bypass = false;

    public static function set(?int $companyId, ?int $unitId = null): void
    {
        self::$companyId = $companyId;
        self::$unitId = $unitId;
    }

    public static function bypass(bool $bypass = true): void
    {
        self::$bypass = $bypass;
    }

    public static function id(): ?int
    {
        if (self::$bypass) {
            return null;
        }

        if (self::$companyId !== null) {
            return self::$companyId;
        }

        $user = auth()->user();

        return $user instanceof User ? $user->company_id : null;
    }

    public static function unitId(): ?int
    {
        if (self::$unitId !== null) {
            return self::$unitId;
        }

        $user = auth()->user();

        return $user instanceof User ? $user->unit_id : null;
    }

    public static function forget(): void
    {
        self::$companyId = null;
        self::$unitId = null;
        self::$bypass = false;
    }
}
