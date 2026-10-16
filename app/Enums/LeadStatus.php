<?php

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'nuevo';
    case CONTACTED = 'contactado';
    case SCHEDULED = 'programado';
    case COMPLETED = 'completado';
    case DISCARDED = 'descartado';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Nuevo',
            self::CONTACTED => 'Contactado',
            self::SCHEDULED => 'Programado',
            self::COMPLETED => 'Completado',
            self::DISCARDED => 'Descartado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'gray',
            self::CONTACTED => 'yellow',
            self::SCHEDULED => 'green',
            self::COMPLETED => 'blue',
            self::DISCARDED => 'red',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::NEW => 'bg-gray-100 text-gray-700 border-gray-200',
            self::CONTACTED => 'bg-amber-50 text-amber-700 border-amber-200',
            self::SCHEDULED => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::COMPLETED => 'bg-blue-50 text-blue-700 border-blue-200',
            self::DISCARDED => 'bg-red-50 text-red-700 border-red-200',
        };
    }

    public function canTransitionTo(self $new): bool
    {
        return match ($this) {
            self::NEW => in_array($new, [self::CONTACTED, self::DISCARDED], true),
            self::CONTACTED => in_array($new, [self::SCHEDULED, self::DISCARDED], true),
            self::SCHEDULED => in_array($new, [self::COMPLETED, self::DISCARDED], true),
            self::COMPLETED => false,
            self::DISCARDED => false,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
