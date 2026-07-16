<?php

namespace App\Enums;

enum StatutExemplaire: string
{
    case DISPONIBLE = 'disponible';
    case EMPRUNTE = 'emprunte';
    case PERDU = 'perdu';
    case REPARATION = 'reparation';

    public function label(): string
    {
        return match ($this) {
            self::DISPONIBLE => 'Disponible',
            self::EMPRUNTE => 'Emprunté',
            self::PERDU => 'Perdu',
            self::REPARATION => 'En réparation',
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
