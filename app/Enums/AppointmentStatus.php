<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case PENDING = 'pendiente';
    case CONFIRMED = 'confirmada';
    case COMPLETED = 'realizada';
    case CANCELLED = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::CONFIRMED => 'Confirmada',
            self::COMPLETED => 'Realizada',
            self::CANCELLED => 'Cancelada',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::PENDING => 'bg-amber-50 text-amber-700 border-amber-200',
            self::CONFIRMED => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::COMPLETED => 'bg-gray-100 text-gray-700 border-gray-200',
            self::CANCELLED => 'bg-red-50 text-red-700 border-red-200',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
