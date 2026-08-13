<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('primaryImage.path')
                    ->label('Imagen')
                    ->square(),
                TextColumn::make('name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->badge()
                    ->color('secondary')
                    ->separator(','),
                TextColumn::make('base_price')
                    ->label('Precio Base')
                    ->money('PEN')
                    ->sortable(),
                TextColumn::make('sale_price')
                    ->label('Precio Oferta')
                    ->money('PEN')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('total_stock')
                    ->label('Stock Total')
                    ->badge()
                    ->color(fn ($state): string => $state > 5 ? 'success' : ($state > 0 ? 'warning' : 'danger')),
                IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),
                IconColumn::make('is_new')
                    ->label('Nuevo')
                    ->boolean(),
                IconColumn::make('is_on_sale')
                    ->label('Oferta')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Creado En')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->label('Categoría')
                    ->relationship('categories', 'name'),
                TernaryFilter::make('is_featured')
                    ->label('Destacados'),
                TernaryFilter::make('is_new')
                    ->label('Nuevos Lanzamientos'),
                TernaryFilter::make('is_on_sale')
                    ->label('En Oferta'),
                TernaryFilter::make('is_active')
                    ->label('Activo'),
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
