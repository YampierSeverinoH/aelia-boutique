<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\AttributeValue;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductVariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $title = 'Variantes del Producto';

    protected static ?string $modelLabel = 'Variante';

    protected static ?string $pluralModelLabel = 'Variantes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de Variante')
                            ->placeholder('Ej. Rosado / M')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sku')
                            ->label('SKU de Variante')
                            ->placeholder('Ej. PO-001-RS-M')
                            ->required()
                            ->maxLength(255),
                    ]),

                Select::make('attributeValues')
                    ->label('Atributos y Valores Asignados (Color, Talla, etc.)')
                    ->relationship('attributeValues', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                Grid::make(5)
                    ->schema([
                        TextInput::make('price')
                            ->label('Precio (S/)')
                            ->numeric()
                            ->prefix('S/')
                            ->required(),
                        TextInput::make('sale_price')
                            ->label('Precio Oferta (S/)')
                            ->numeric()
                            ->prefix('S/'),
                        TextInput::make('cost')
                            ->label('Costo Interno (S/)')
                            ->numeric()
                            ->prefix('S/'),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Variante Activa')
                            ->default(true)
                    ])->columnSpanFull(),

                

                Repeater::make('images')
                    ->label('Imágenes Específicas de esta Variante (Efecto Hover / Cambio de Color)')
                    ->relationship('images')
                    ->schema([
                        FileUpload::make('path')
                            ->label('Imagen')
                            ->image()
                            ->directory('variant-images')
                            ->required(),
                        TextInput::make('alt')
                            ->label('Texto Alternativo (SEO)'),
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->orderColumn('sort_order')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Variante')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('attributeValues.name')
                    ->label('Atributos')
                    ->badge()
                    ->color('info')
                    ->separator(' / '),
                TextColumn::make('price')
                    ->label('Precio Base')
                    ->money('PEN')
                    ->sortable(),
                TextColumn::make('sale_price')
                    ->label('Precio Oferta')
                    ->money('PEN')
                    ->placeholder('-'),
                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => $state > 0 ? 'success' : 'danger'),
                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
