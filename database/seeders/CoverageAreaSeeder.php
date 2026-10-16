<?php

namespace Database\Seeders;

use App\Models\CoverageArea;
use Illuminate\Database\Seeder;

class CoverageAreaSeeder extends Seeder
{
    public function run(): void
    {
         
        $areas = [
            ['postal_code' => '28001', 'city' => 'Madrid', 'province' => 'Madrid'],
            ['postal_code' => '08001', 'city' => 'Barcelona', 'province' => 'Barcelona'],
            ['postal_code' => '46001', 'city' => 'Valencia', 'province' => 'Valencia'],
            ['postal_code' => '41001', 'city' => 'Sevilla', 'province' => 'Sevilla'],
            ['postal_code' => '48001', 'city' => 'Bilbao', 'province' => 'Vizcaya'],
            ['postal_code' => '50001', 'city' => 'Zaragoza', 'province' => 'Zaragoza'],
            ['postal_code' => '29001', 'city' => 'Málaga', 'province' => 'Málaga'],
            ['postal_code' => '30001', 'city' => 'Murcia', 'province' => 'Murcia'],
        ];

        foreach ($areas as $area) {
            CoverageArea::firstOrCreate(
                ['postal_code' => $area['postal_code'], 'city' => $area['city']],
                array_merge($area, ['is_covered' => true])
            );
        }
    }
}
