<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
         
        $partners = [
            ['name' => 'REPSOL', 'icon_class' => 'fa-solid fa-bolt'],
            ['name' => 'Naturgy', 'icon_class' => 'fa-solid fa-fire'],
            ['name' => 'Iberdrola', 'icon_class' => 'fa-solid fa-wind'],
            ['name' => 'Endesa', 'icon_class' => 'fa-solid fa-solar-panel'],
            ['name' => 'EDP', 'icon_class' => 'fa-solid fa-plug'],
            ['name' => 'TotalEnergies', 'icon_class' => 'fa-solid fa-leaf'],
            ['name' => 'LG Solar', 'icon_class' => 'fa-solid fa-handshake'],
            ['name' => 'Daikin', 'icon_class' => 'fa-solid fa-handshake'],
            ['name' => 'Vaillant', 'icon_class' => 'fa-solid fa-handshake'],
        ];

        foreach ($partners as $index => $partner) {
            Partner::firstOrCreate(
                ['slug' => Str::slug($partner['name'])],
                [
                    'name' => $partner['name'],
                    'icon_class' => $partner['icon_class'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
