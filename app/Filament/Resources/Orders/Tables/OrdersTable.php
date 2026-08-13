<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('N° Pedido')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_phone')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('PEN')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Pago')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'verified' => 'info',
                        default => 'warning',
                    }),
                TextColumn::make('order_status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'delivered' => 'success',
                        'shipped' => 'info',
                        'processing' => 'primary',
                        'cancelled' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('order_status')
                    ->label('Estado Pedido')
                    ->options([
                        'pending' => 'Pendiente',
                        'processing' => 'En Preparación',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Estado Pago')
                    ->options([
                        'pending' => 'Pendiente',
                        'verified' => 'Verificado',
                        'paid' => 'Pagado',
                    ]),
            ])
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
