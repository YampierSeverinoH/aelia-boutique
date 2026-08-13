<?php

namespace App\Filament\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Trayectoria y Métricas')
                    ->schema([
                        RichEditor::make('trayectoria')
                            ->label('Historia y Trayectoria')
                            ->required()
                            ->columnSpanFull(),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('anios')
                                    ->label('Años de Experiencia')
                                    ->placeholder('Ej. 10+')
                                    ->required(),
                                TextInput::make('patentes')
                                    ->label('Patentes / Diseños')
                                    ->placeholder('Ej. 25+')
                                    ->required(),
                                TextInput::make('paises')
                                    ->label('Países / Presencia')
                                    ->placeholder('Ej. 5')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Misión, Visión y Valores')
                    ->schema([
                        Textarea::make('mision')
                            ->label('Misión')
                            ->rows(3)
                            ->required(),
                        Textarea::make('vision')
                            ->label('Visión')
                            ->rows(3)
                            ->required(),
                        Textarea::make('valores')
                            ->label('Valores de la Marca')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Galería de Imágenes Institucionales')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                FileUpload::make('imagen_1')
                                    ->label('Imagen 1')
                                    ->image()
                                    ->directory('about'),
                                FileUpload::make('imagen_2')
                                    ->label('Imagen 2')
                                    ->image()
                                    ->directory('about'),
                                FileUpload::make('imagen_3')
                                    ->label('Imagen 3')
                                    ->image()
                                    ->directory('about'),
                                FileUpload::make('imagen_4')
                                    ->label('Imagen 4')
                                    ->image()
                                    ->directory('about'),
                            ]),
                    ]),

                Section::make('Sección Talento Humano')
                    ->schema([
                        FileUpload::make('imagen_talento')
                            ->label('Imagen de Talento / Equipo')
                            ->image()
                            ->directory('about'),
                        TextInput::make('titulo_talento')
                            ->label('Título de Sección Talento')
                            ->required(),
                        Textarea::make('descripcion_talento')
                            ->label('Descripción del Talento / Equipo')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Subtítulos Destacados')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('subtitulo_1')
                                    ->label('Subtítulo 1')
                                    ->required(),
                                Textarea::make('subtitulo_1_descripcion')
                                    ->label('Descripción Subtítulo 1')
                                    ->rows(3)
                                    ->required(),
                                TextInput::make('subtitulo_2')
                                    ->label('Subtítulo 2')
                                    ->required(),
                                Textarea::make('subtitulo_2_descripcion')
                                    ->label('Descripción Subtítulo 2')
                                    ->rows(3)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
