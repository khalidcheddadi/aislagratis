<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case SALES = 'sales';
    case TECHNICIAN = 'technician';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::SALES => 'Comercial',
            self::TECHNICIAN => 'Técnico',
            self::CUSTOMER => 'Cliente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ADMIN => '#92400E',
            self::SALES => '#9D174D',
            self::TECHNICIAN => '#075985',
            self::CUSTOMER => '#374151',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::ADMIN => 'bg-amber-100 text-amber-800',
            self::SALES => 'bg-pink-100 text-pink-800',
            self::TECHNICIAN => 'bg-sky-100 text-sky-800',
            self::CUSTOMER => 'bg-gray-100 text-gray-700',
        };
    }

    public function canManage(): bool
    {
        return in_array($this, [self::ADMIN, self::SALES], true);
    }
}
