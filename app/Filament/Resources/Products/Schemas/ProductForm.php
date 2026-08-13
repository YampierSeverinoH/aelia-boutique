<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Producto')
                    ->tabs([
                        Tabs\Tab::make('Información General')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Producto')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                    ),
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('sku')
                                    ->label('SKU Principal')
                                    ->placeholder('EJ: AEL-001')
                                    ->unique(ignoreRecord: true),
                                Select::make('categories')
                                    ->label('Categorías')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('short_description')
                                    ->label('Descripción Corta (Extracto)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->label('Descripción Completa (Detalles, Composición, Cuidados)')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Precios e Inventario')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('base_price')
                                            ->label('Precio Regular (S/)')
                                            ->numeric()
                                            ->prefix('S/')
                                            ->required()
                                            ->default(0.00),
                                        TextInput::make('sale_price')
                                            ->label('Precio Oferta (S/)')
                                            ->numeric()
                                            ->prefix('S/'),
                                        TextInput::make('cost')
                                            ->label('Costo Interno (S/)')
                                            ->numeric()
                                            ->prefix('S/'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('stock')
                                            ->label('Stock Base (Solo sin variantes)')
                                            ->numeric()
                                            ->default(0),
                                        Toggle::make('has_variants')
                                            ->label('¿Este producto posee múltiples variantes (Tallas/Colores)?')
                                            ->default(false)
                                            ->helperText('Al activar, el stock total se gestionará desde las variantes del producto.'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Clasificación & Estado')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Publicado / Activo')
                                            ->default(true),
                                        Toggle::make('is_featured')
                                            ->label('⭐ Producto Destacado')
                                            ->default(false),
                                        Toggle::make('is_new')
                                            ->label('🆕 Nuevo Lanzamiento')
                                            ->default(true),
                                        Toggle::make('is_on_sale')
                                            ->label('🔥 En Oferta')
                                            ->default(false),
                                    ]),
                                DateTimePicker::make('published_at')
                                    ->label('Fecha de Publicación')
                                    ->default(now()),
                            ]),

                        Tabs\Tab::make('Galería de Imágenes')
                            ->schema([
                                Repeater::make('images')
                                    ->relationship('images')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('Imagen del Producto')
                                            ->image()
                                            ->directory('products')
                                            ->required(),
                                        TextInput::make('alt')
                                            ->label('Texto Alternativo (SEO)'),
                                        Toggle::make('is_primary')
                                            ->label('Imagen Principal Portada')
                                            ->default(false),
                                        TextInput::make('sort_order')
                                            ->label('Orden')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(1)
                                    ->orderColumn('sort_order')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('SEO & Meta')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Título SEO')
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->label('Meta Descripción SEO')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
