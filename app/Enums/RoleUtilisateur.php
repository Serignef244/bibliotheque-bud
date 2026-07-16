<?php

namespace App\Enums;

enum RoleUtilisateur: string
{
    case ADMIN = 'admin';
    case BIBLIOTHECAIRE = 'bibliothecaire';
    case ADHERENT = 'adherent';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::BIBLIOTHECAIRE => 'Bibliothécaire',
            self::ADHERENT => 'Adhérent',
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
