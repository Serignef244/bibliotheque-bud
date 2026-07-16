<?php

namespace App\Enums;

enum StatutPenalite: string
{
    case IMPAYE = 'impaye';
    case PAYE = 'paye';
    case PARTIEL = 'partiel';

    public function label(): string
    {
        return match ($this) {
            self::IMPAYE => 'Impayé',
            self::PAYE => 'Payé',
            self::PARTIEL => 'Partiellement payé',
        };
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function liste(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::liste(), 'value');
    }

    public static function tryFromValue(?string $value): ?self
    {
        return self::tryFrom($value ?? '');
    }
}
