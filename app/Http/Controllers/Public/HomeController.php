<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class HomeController extends Controller
{
    public function index(): View
    {
        $cities = $this->mapCities();

        return ViewFacade::make('public.home', compact('cities'));
    }

    public function coverage(): View
    {
        $cities = collect($this->mapCities())
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        return ViewFacade::make('public.coverage', compact('cities'));
    }

    private function mapCities(): array
    {
        return [
            ['name' => 'Madrid', 'lat' => 40.4168, 'lng' => -3.7038],
            ['name' => 'Alcalá de Henares', 'lat' => 40.4817, 'lng' => -3.3641],
            ['name' => 'Guadalajara', 'lat' => 40.6337, 'lng' => -3.1674],
            ['name' => 'Segovia', 'lat' => 40.9429, 'lng' => -4.1088],
            ['name' => 'Ávila', 'lat' => 40.6566, 'lng' => -4.6818],
            ['name' => 'Salamanca', 'lat' => 40.9701, 'lng' => -5.6635],
            ['name' => 'Valladolid', 'lat' => 41.6523, 'lng' => -4.7245],
            ['name' => 'Palencia', 'lat' => 42.0096, 'lng' => -4.5288],
            ['name' => 'Burgos', 'lat' => 42.3440, 'lng' => -3.6969],
            ['name' => 'León', 'lat' => 42.5987, 'lng' => -5.5671],
            ['name' => 'Zamora', 'lat' => 41.5035, 'lng' => -5.7446],
            ['name' => 'Soria', 'lat' => 41.7666, 'lng' => -2.4790],
            ['name' => 'Logroño', 'lat' => 42.4627, 'lng' => -2.4449],
            ['name' => 'Pamplona', 'lat' => 42.8125, 'lng' => -1.6458],
            ['name' => 'Tudela', 'lat' => 42.0617, 'lng' => -1.6067],
            ['name' => 'Vitoria-Gasteiz', 'lat' => 42.8467, 'lng' => -2.6727],
            ['name' => 'Bilbao', 'lat' => 43.2630, 'lng' => -2.9350],
            ['name' => 'Barakaldo', 'lat' => 43.2972, 'lng' => -2.9916],
            ['name' => 'San Sebastián', 'lat' => 43.3183, 'lng' => -1.9812],
            ['name' => 'Santander', 'lat' => 43.4623, 'lng' => -3.8100],
            ['name' => 'Torrelavega', 'lat' => 43.3494, 'lng' => -4.0479],
            ['name' => 'Oviedo', 'lat' => 43.3614, 'lng' => -5.8494],
            ['name' => 'Gijón', 'lat' => 43.5322, 'lng' => -5.6611],
            ['name' => 'Avilés', 'lat' => 43.5561, 'lng' => -5.9248],
            ['name' => 'A Coruña', 'lat' => 43.3623, 'lng' => -8.4115],
            ['name' => 'Santiago de Compostela', 'lat' => 42.8782, 'lng' => -8.5448],
            ['name' => 'Ferrol', 'lat' => 43.4896, 'lng' => -8.2193],
            ['name' => 'Lugo', 'lat' => 43.0121, 'lng' => -7.5559],
            ['name' => 'Ourense', 'lat' => 42.3358, 'lng' => -7.8639],
            ['name' => 'Pontevedra', 'lat' => 42.4310, 'lng' => -8.6444],
            ['name' => 'Vigo', 'lat' => 42.2406, 'lng' => -8.7207],
            ['name' => 'Zaragoza', 'lat' => 41.6488, 'lng' => -0.8891],
            ['name' => 'Huesca', 'lat' => 42.1401, 'lng' => -0.4089],
            ['name' => 'Calatayud', 'lat' => 41.3557, 'lng' => -1.6432],
            ['name' => 'Barcelona', 'lat' => 41.3874, 'lng' => 2.1686],
            ['name' => 'Girona', 'lat' => 41.9794, 'lng' => 2.8214],
            ['name' => 'Lleida', 'lat' => 41.6176, 'lng' => 0.6200],
            ['name' => 'Tarragona', 'lat' => 41.1189, 'lng' => 1.2445],
            ['name' => 'Reus', 'lat' => 41.1498, 'lng' => 1.1050],
            ['name' => 'Figueres', 'lat' => 42.2679, 'lng' => 2.9610],
            ['name' => 'Manresa', 'lat' => 41.7280, 'lng' => 1.8260],
            ['name' => 'Vic', 'lat' => 41.9300, 'lng' => 2.2540],
            ['name' => 'Mataró', 'lat' => 41.5381, 'lng' => 2.4447],
            ['name' => 'Granollers', 'lat' => 41.6080, 'lng' => 2.2870],
            ['name' => 'Vilanova i la Geltrú', 'lat' => 41.2242, 'lng' => 1.7250],
            ['name' => 'Ponferrada', 'lat' => 42.5466, 'lng' => -6.5962],
            ['name' => 'Miranda de Ebro', 'lat' => 42.6866, 'lng' => -2.9470],
            ['name' => 'Aranda de Duero', 'lat' => 41.6704, 'lng' => -3.6880],
            ['name' => 'Laredo', 'lat' => 43.4098, 'lng' => -3.4160],
            ['name' => 'Castro-Urdiales', 'lat' => 43.3829, 'lng' => -3.2200],
            ['name' => 'Langreo', 'lat' => 43.2968, 'lng' => -5.6840],
            ['name' => 'Monforte de Lemos', 'lat' => 42.5217, 'lng' => -7.5140],
            ['name' => 'Vilagarcía de Arousa', 'lat' => 42.5952, 'lng' => -8.7660],
            ['name' => 'Eibar', 'lat' => 43.1849, 'lng' => -2.4710],
        ];
    }
}
