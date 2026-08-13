<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Schemas\AboutForm;
use App\Models\About;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageAbout extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static UnitEnum|string|null $navigationGroup = 'Contenido y Páginas';

    protected static ?string $title = 'Nosotros';

    protected static ?string $navigationLabel = 'Nosotros';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.manage-about';

    public ?array $data = [];

    public function mount(): void
    {
        $about = About::first();

        if (! $about) {
            $about = About::create([
                'trayectoria' => 'Historia de Aelia Boutique...',
                'anios' => '8+',
                'patentes' => '15+',
                'paises' => '3',
                'mision' => 'Misión de Aelia Boutique...',
                'vision' => 'Visión de Aelia Boutique...',
                'valores' => 'Valores de Aelia Boutique...',
                'titulo_talento' => 'Nuestro Equipo',
                'descripcion_talento' => 'Descripción del equipo...',
                'subtitulo_1' => 'Confección Artesanal',
                'subtitulo_1_descripcion' => 'Descripción...',
                'subtitulo_2' => 'Materiales de Selección',
                'subtitulo_2_descripcion' => 'Descripción...',
            ]);
        }

        $this->form->fill($about->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return AboutForm::configure($schema)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $about = About::first();
        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        Notification::make()
            ->title('Información de Nosotros guardada correctamente')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar Cambios')
                ->submit('save'),
        ];
    }
}
