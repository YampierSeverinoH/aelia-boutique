<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Pedido')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('order_number')
                                    ->label('Número de Pedido')
                                    ->disabled()
                                    ->dehydrated(false),
                                Select::make('order_status')
                                    ->label('Estado del Pedido')
                                    ->options([
                                        'pending' => '⏳ Pendiente de Pago',
                                        'processing' => '⚙️ En Preparación',
                                        'shipped' => '🚚 Enviado',
                                        'delivered' => '✅ Entregado',
                                        'cancelled' => '❌ Cancelado',
                                    ])
                                    ->required(),
                                Select::make('payment_status')
                                    ->label('Estado de Pago')
                                    ->options([
                                        'pending' => 'Pendiente',
                                        'verified' => 'Pago Verificado',
                                        'paid' => 'Pagado',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('Datos del Cliente y Envío')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('customer_name')
                                    ->label('Cliente')
                                    ->required(),
                                TextInput::make('customer_email')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->required(),
                                TextInput::make('customer_phone')
                                    ->label('Teléfono / WhatsApp')
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('document_type')
                                    ->label('Documento')
                                    ->default('DNI'),
                                TextInput::make('document_number')
                                    ->label('Número Doc.'),
                                TextInput::make('shipping_agency')
                                    ->label('Agencia / Courier'),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('region')
                                    ->label('Región / Dpto')
                                    ->required(),
                                TextInput::make('province')
                                    ->label('Provincia'),
                                TextInput::make('district')
                                    ->label('Distrito'),
                            ]),
                        TextInput::make('shipping_address')
                            ->label('Dirección de Entrega')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('reference')
                            ->label('Referencia de Dirección')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Prendas Solicitadas')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                TextInput::make('product_name')
                                    ->label('Producto')
                                    ->required(),
                                TextInput::make('variant_name')
                                    ->label('Variante (Color/Talla)'),
                                TextInput::make('sku')
                                    ->label('SKU'),
                                TextInput::make('price')
                                    ->label('Precio (S/)')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('subtotal')
                                    ->label('Subtotal (S/)')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required(),
                            ])
                            ->columns(6)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Section::make('Totales y Notas')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('subtotal')
                                    ->label('Subtotal Prendas (S/)')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required(),
                                TextInput::make('shipping_cost')
                                    ->label('Costo de Envío (S/)')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required(),
                                TextInput::make('total')
                                    ->label('Total a Pagar (S/)')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required(),
                            ]),
                        Textarea::make('notes')
                            ->label('Notas del Pedido')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ])->columns(1);
    }
}
