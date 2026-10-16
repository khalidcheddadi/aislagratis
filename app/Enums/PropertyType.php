<?php

namespace App\Enums;

enum PropertyType: string
{
    case CASA_UNIFAMILIAR = 'casa_unifamiliar';
    case EDIFICIO = 'edificio';
    case PISO = 'piso';
    case ATICO = 'atico';
    case SOTANO = 'sotano';
    case NAVE_INDUSTRIAL = 'nave_industrial';
    case LOCAL = 'local';

    public function label(): string
    {
        return match ($this) {
            self::CASA_UNIFAMILIAR => 'Casa unifamiliar',
            self::EDIFICIO => 'Edificio',
            self::PISO => 'Piso',
            self::ATICO => 'Ático',
            self::SOTANO => 'Sótano',
            self::NAVE_INDUSTRIAL => 'Nave industrial',
            self::LOCAL => 'Local',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn ($c) => [$c->value => $c->label()]
        )->toArray();
    }
}
