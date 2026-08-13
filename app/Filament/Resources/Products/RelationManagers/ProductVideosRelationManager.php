<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductVideosRelationManager extends RelationManager
{
    protected static string $relationship = 'videos';

    protected static ?string $title = 'Videos del Producto';

    protected static ?string $modelLabel = 'Video';

    protected static ?string $pluralModelLabel = 'Videos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título del Video')
                    ->placeholder('Ej. Pasarela / Demostración de prenda')
                    ->maxLength(255),
                Select::make('type')
                    ->label('Proveedor/Tipo')
                    ->options([
                        'youtube' => 'YouTube Embed',
                        'vimeo' => 'Vimeo Embed',
                        'embed' => 'URL Externa Enbebida',
                    ])
                    ->default('youtube')
                    ->required(),
                TextInput::make('url')
                    ->label('URL del Video o Código Embed')
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->url()
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->placeholder('Sin título')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Proveedor')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('url')
                    ->label('URL / Enlace')
                    ->limit(40)
                    ->url(fn ($record) => $record->url, true),
                IconColumn::make('is_active')
                    ->label('Activo')
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
