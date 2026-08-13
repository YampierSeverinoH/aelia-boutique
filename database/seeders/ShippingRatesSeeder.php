<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            [
                'region' => 'Lima',
                'province' => 'Lima Metropolitana',
                'agency' => 'Delivery Express San Isidro / Miraflores',
                'cost' => 12.00,
                'delivery_time_days' => '24 horas',
                'is_active' => true,
            ],
            [
                'region' => 'Lima',
                'province' => 'Lima Provincias',
                'agency' => 'Olva Courier',
                'cost' => 15.00,
                'delivery_time_days' => '24 a 48 horas',
                'is_active' => true,
            ],
            [
                'region' => 'Arequipa',
                'province' => 'Arequipa',
                'agency' => 'Shalom / Olva Courier',
                'cost' => 20.00,
                'delivery_time_days' => '2 a 3 días hábiles',
                'is_active' => true,
            ],
            [
                'region' => 'La Libertad',
                'province' => 'Trujillo',
                'agency' => 'Shalom / Olva Courier',
                'cost' => 20.00,
                'delivery_time_days' => '2 a 3 días hábiles',
                'is_active' => true,
            ],
            [
                'region' => 'Cusco',
                'province' => 'Cusco',
                'agency' => 'Shalom Cargo',
                'cost' => 25.00,
                'delivery_time_days' => '3 a 4 días hábiles',
                'is_active' => true,
            ],
            [
                'region' => 'Otras Regiones',
                'province' => null,
                'agency' => 'Envío Nacional Estándar',
                'cost' => 25.00,
                'delivery_time_days' => '3 a 5 días hábiles',
                'is_active' => true,
            ],
        ];

        foreach ($rates as $rate) {
            ShippingRate::create($rate);
        }
    }
}
