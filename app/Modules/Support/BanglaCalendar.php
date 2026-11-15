<?php

declare(strict_types=1);

namespace App\Modules\Support;

use DateTimeImmutable;
use Tarikh\Tarikh;

/**
 * Bangladesh revised Bangla calendar, registered on Tarikh because the
 * published package has no calendar conversion of its own.
 */
final class BanglaCalendar
{
    /** @var array<int, string> */
    public const MONTHS_BN = [
        1 => 'বৈশাখ',
        2 => 'জ্যৈষ্ঠ',
        3 => 'আষাঢ়',
        4 => 'শ্রাবণ',
        5 => 'ভাদ্র',
        6 => 'আশ্বিন',
        7 => 'কার্তিক',
        8 => 'অগ্রহায়ণ',
        9 => 'পৌষ',
        10 => 'মাঘ',
        11 => 'ফাল্গুন',
        12 => 'চৈত্র',
    ];

    /** @var array<int, string> */
    public const MONTHS_EN = [
        1 => 'Boishakh',
        2 => 'Joishtho',
        3 => 'Asharh',
        4 => 'Srabon',
        5 => 'Bhadro',
        6 => 'Ashwin',
        7 => 'Kartik',
        8 => 'Agrahayon',
        9 => 'Poush',
        10 => 'Magh',
        11 => 'Falgun',
        12 => 'Choitro',
    ];

    /** @return array{year: int, month: int, day: int, month_bn: string, month_en: string} */
    public static function convert(DateTimeImmutable $date): array
    {
        $year = (int) $date->format('Y');
        $month = (int) $date->format('n');
        $day = (int) $date->format('j');
        $onOrAfterNewYear = $month > 4 || ($month === 4 && $day >= 14);
        $startYear = $onOrAfterNewYear ? $year : $year - 1;
        $start = new DateTimeImmutable(sprintf('%04d-04-14', $startYear));
        $elapsed = (int) $start->diff($date->setTime(0, 0))->days;
        $falgunDays = (int) (new DateTimeImmutable(sprintf('%04d-01-01', $startYear + 1)))->format('L') === 1 ? 31 : 30;
        $lengths = [31, 31, 31, 31, 31, 30, 30, 30, 30, 30, $falgunDays, 30];
        $remaining = $elapsed;
        $banglaMonth = 1;

        foreach ($lengths as $index => $length) {
            if ($remaining < $length) {
                $banglaMonth = $index + 1;
                break;
            }
            $remaining -= $length;
            $banglaMonth = $index + 2;
        }

        if ($banglaMonth > 12) {
            $banglaMonth = 12;
            $remaining = $lengths[11] - 1;
        }

        return [
            'year' => $onOrAfterNewYear ? $year - 593 : $year - 594,
            'month' => $banglaMonth,
            'day' => $remaining + 1,
            'month_bn' => self::MONTHS_BN[$banglaMonth],
            'month_en' => self::MONTHS_EN[$banglaMonth],
        ];
    }

    public static function digits(int|float|string $value): string
    {
        return strtr((string) $value, [
            '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
            '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
        ]);
    }

    public static function registerMacros(): void
    {
        if (! Tarikh::hasMacro('toBangla')) {
            Tarikh::macro('toBangla', function (): array {
                /** @var Tarikh $this */
                return BanglaCalendar::convert(new DateTimeImmutable($this->toDateTimeString()));
            });
        }

        if (! Tarikh::hasMacro('banglaDigits')) {
            Tarikh::macro('banglaDigits', function (int|float|string $value): string {
                return BanglaCalendar::digits($value);
            });
        }
    }
}
