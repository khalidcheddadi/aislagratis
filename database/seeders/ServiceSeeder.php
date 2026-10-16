<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
         
        $services = [
            [
                'name' => 'Aislamiento de fachadas',
                'description' => 'Mejora la envolvente térmica de tu edificio con sistemas SATE de última generación.',
                'icon_class' => 'fa-solid fa-house-chimney',
                'base_price' => 2500,
                'estimated_hours' => 40,
            ],
            [
                'name' => 'Inyección de cámaras',
                'description' => 'Relleno de cámaras de aire con espuma aislante para eliminar puentes térmicos.',
                'icon_class' => 'fa-solid fa-layer-group',
                'base_price' => 1500,
                'estimated_hours' => 16,
            ],
            [
                'name' => 'Aislamiento de cubiertas',
                'description' => 'Soluciones para tejados y cubiertas planas que reducen la pérdida de calor.',
                'icon_class' => 'fa-solid fa-warehouse',
                'base_price' => 3000,
                'estimated_hours' => 32,
            ],
            [
                'name' => 'Suelos radiantes',
                'description' => 'Sistemas de calefacción eficiente por suelo radiante con aislamiento integrado.',
                'icon_class' => 'fa-solid fa-fire',
                'base_price' => 4500,
                'estimated_hours' => 60,
            ],
            [
                'name' => 'Ventanas eficientes',
                'description' => 'Sustitución de ventanas por modelos de alta eficiencia energética con rotura de puente térmico.',
                'icon_class' => 'fa-solid fa-window-maximize',
                'base_price' => 3500,
                'estimated_hours' => 24,
            ],
            [
                'name' => 'Aislamiento acústico',
                'description' => 'Soluciones integrales para reducir el ruido y mejorar el confort en tu hogar.',
                'icon_class' => 'fa-solid fa-volume-high',
                'base_price' => 2200,
                'estimated_hours' => 20,
            ],
        ];

        foreach ($services as $index => $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                array_merge($service, [
                    'sort_order' => $index,
                    'is_active' => true,
                ])
            );
        }
    }
}
