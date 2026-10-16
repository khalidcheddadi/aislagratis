<?php

namespace App\Enums;

enum InstallationStatus: string
{
    case SCHEDULED = 'programada';
    case IN_PROGRESS = 'en_progreso';
    case COMPLETED = 'completada';
    case WARRANTY = 'garantia';

    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Programada',
            self::IN_PROGRESS => 'En progreso',
            self::COMPLETED => 'Completada',
            self::WARRANTY => 'En garantía',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::SCHEDULED => 'bg-amber-50 text-amber-700 border-amber-200',
            self::IN_PROGRESS => 'bg-blue-50 text-blue-700 border-blue-200',
            self::COMPLETED => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::WARRANTY => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
