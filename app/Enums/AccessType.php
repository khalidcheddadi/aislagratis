<?php

namespace App\Enums;

enum AccessType: string
{
    case ESCALERA = 'escalera';
    case SIN_ACCESO = 'sin_acceso';

    public function label(): string
    {
        return match ($this) {
            self::ESCALERA => 'Escalera',
            self::SIN_ACCESO => 'Sin acceso',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn ($c) => [$c->value => $c->label()]
        )->toArray();
    }
}
