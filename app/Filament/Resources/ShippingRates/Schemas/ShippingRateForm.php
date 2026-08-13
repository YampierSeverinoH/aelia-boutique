<?php

namespace App\Filament\Resources\ShippingRates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ShippingRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('region')
                    ->label('Región / Departamento')
                    ->placeholder('Ej. Lima, Arequipa, Cusco')
                    ->required(),
                TextInput::make('province')
                    ->label('Provincia (Opcional)')
                    ->placeholder('Ej. Lima, Trujillo, Chiclayo'),
                TextInput::make('agency')
                    ->label('Agencia / Courier de Envío')
                    ->placeholder('Ej. Olva Courier, Shalom, Deliveries Lima')
                    ->required(),
                TextInput::make('cost')
                    ->label('Costo de Envío (S/)')
                    ->numeric()
                    ->prefix('S/')
                    ->required(),
                TextInput::make('delivery_time_days')
                    ->label('Tiempo de Entrega')
                    ->placeholder('Ej. 24 a 48 horas / 2-3 días habiles'),
                Toggle::make('is_active')
                    ->label('Tarifa Activa')
                    ->default(true),
            ]);
    }
}
