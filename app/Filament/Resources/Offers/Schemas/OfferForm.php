<?php

namespace App\Filament\Resources\Offers\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título de la Oferta / Promoción')
                    ->placeholder('Ej. Elegancia & Sofisticación en Cada Detalle')
                    ->required(),

                FileUpload::make('imagen')
                    ->label('Imagen de la Oferta')
                    ->image()
                    ->directory('offers')
                    ->required()
                    ->imageEditor()
                    ->columnSpanFull(),

                Textarea::make('descripcion_corta')
                    ->label('Descripción Corta')
                    ->placeholder('Nuestra filosofía combina siluetas clásicas con cortes contemporáneos y telas finas de algodón pima y seda. Diseñado en Perú para la mujer exigente.')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('product_id')
                    ->label('Producto Específico a Redireccionar (Opcional)')
                    ->options(Product::active()->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Selecciona un producto específico...'),

                TextInput::make('link')
                    ->label('O Enlace / URL Personalizado (Opcional)')
                    ->placeholder('Ej. /catalogo?on_sale=1 o https://...'),

                TextInput::make('sort_order')
                    ->label('Orden de Visualización')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Oferta Activa')
                    ->default(true),
            ]);
    }
}
