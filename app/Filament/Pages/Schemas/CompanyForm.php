<?php

namespace App\Filament\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Empresa')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo de la Empresa')
                            ->image()
                            ->directory('company'),
                        FileUpload::make('imagen_bio')
                            ->label('Imagen / Avatar para Bienvenida Bio (Linktree)')
                            ->image()
                            ->directory('company'),
                        TextInput::make('ruc')
                            ->label('RUC')
                            ->placeholder('Ej. 20123456789'),
                        TextInput::make('mensaje_cinta')
                            ->label('Mensaje de la Cinta Superior (Cinta con Movimiento)')
                            ->placeholder('Ej. ✨ Envíos gratis a todo el Perú por compras mayores a S/ 199.00 ✨')
                            ->columnSpanFull(),
                        Textarea::make('descripcion')
                            ->label('Descripción Breve')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Contacto y Horarios')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('telefono')
                                    ->label('Teléfono / WhatsApp')
                                    ->required(),
                                TextInput::make('horario')
                                    ->label('Horario de Atención')
                                    ->placeholder('Ej. Lunes a Sábado: 9am - 8pm')
                                    ->required(),
                                TextInput::make('correo')
                                    ->label('Correo Público')
                                    ->email()
                                    ->required(),
                                TextInput::make('correo_notificaciones')
                                    ->label('Correo de Notificaciones / Pedidos')
                                    ->email()
                                    ->required(),
                            ]),
                        TextInput::make('direccion')
                            ->label('Dirección Física')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('ubicacion')
                            ->label('Ubicación Google Maps (Embed / URL Iframe)')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Redes Sociales')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('link_facebook')
                                    ->label('Facebook')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('link_instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('link_tiktok')
                                    ->label('TikTok')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('link_youtube')
                                    ->label('YouTube')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('link_linkedin')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->prefix('https://'),
                            ]),
                    ]),

                Section::make('Políticas y Términos Legales')
                    ->schema([
                        RichEditor::make('terminos_condiciones')
                            ->label('Términos y Condiciones')
                            ->columnSpanFull(),
                        RichEditor::make('politicas_privacidad')
                            ->label('Políticas de Privacidad')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
