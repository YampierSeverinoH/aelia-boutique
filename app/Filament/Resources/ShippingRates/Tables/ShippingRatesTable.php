<?php

namespace App\Filament\Resources\ShippingRates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShippingRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('region')
                    ->label('Región / Dpto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('province')
                    ->label('Provincia')
                    ->placeholder('Todas'),
                TextColumn::make('agency')
                    ->label('Agencia')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('cost')
                    ->label('Costo')
                    ->money('PEN')
                    ->sortable(),
                TextColumn::make('delivery_time_days')
                    ->label('Tiempo de Entrega')
                    ->placeholder('-'),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
