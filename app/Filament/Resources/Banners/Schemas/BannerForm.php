<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Banner')
                    ->required()
                    ->maxLength(255),
                TextInput::make('titulo')
                    ->label('Título (Encabezado Visual)')
                    ->maxLength(255),
                FileUpload::make('imagen')
                    ->label('Imagen del Banner')
                    ->image()
                    ->directory('banners')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('descripcion')
                    ->label('Descripción / Subtítulo')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
