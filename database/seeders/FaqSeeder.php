<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
         
        $faqs = [
            [
                'question' => '¿Puedo beneficiarme de estas ayudas?',
                'answer' => 'Las ayudas están destinadas a propietarios que desean mejorar la eficiencia energética de su vivienda mediante trabajos de aislamiento térmico.',
            ],
            [
                'question' => '¿Qué ayudas existen para aislar mi vivienda?',
                'answer' => 'En algunos casos, las ayudas disponibles pueden cubrir una parte significativa del coste de los trabajos. La elegibilidad depende de las características de la vivienda y de cada proyecto.',
            ],
            [
                'question' => '¿Cómo puedo saber si soy elegible?',
                'answer' => 'Completa el formulario y uno de nuestros especialistas analizará tu situación de forma gratuita y sin compromiso.',
            ],
            [
                'question' => '¿Qué son los Certificados CAE?',
                'answer' => 'Los Certificados de Ahorro Energético (CAE) son un sistema que promueve las mejoras de eficiencia energética y permite acceder a importantes ayudas para determinados proyectos.',
            ],
            [
                'question' => '¿Qué tipo de trabajos de aislamiento se pueden realizar?',
                'answer' => 'Dependiendo de la vivienda, pueden realizarse actuaciones en fachadas, cubiertas, tejados o cerramientos para mejorar la eficiencia energética.',
            ],
            [
                'question' => '¿Cuánto duran los trabajos?',
                'answer' => 'La duración depende del tipo de intervención y de la superficie a tratar. Nuestro equipo te informará durante el estudio inicial.',
            ],
            [
                'question' => '¿Tiene algún coste solicitar el estudio?',
                'answer' => 'No. El análisis inicial y la verificación de elegibilidad se realizan de forma gratuita y sin compromiso.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['sort_order' => $index, 'is_active' => true])
            );
        }
    }
}
