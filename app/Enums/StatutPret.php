<?php

namespace App\Enums;

enum StatutPret: string
{
    case EN_COURS = 'en_cours';
    case RENDU = 'rendu';
    case RETARD = 'retard';

    public function label(): string
    {
        return match ($this) {
            self::EN_COURS => 'En cours',
            self::RENDU => 'Rendu',
            self::RETARD => 'En retard',
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
