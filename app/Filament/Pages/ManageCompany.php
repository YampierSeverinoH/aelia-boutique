<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Schemas\CompanyForm;
use App\Models\Company;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageCompany extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static UnitEnum|string|null $navigationGroup = 'Configuración y Empresa';

    protected static ?string $title = 'Información de la Empresa';

    protected static ?string $navigationLabel = 'Empresa';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.manage-company';

    public ?array $data = [];

    public function mount(): void
    {
        $company = Company::first();

        if (! $company) {
            $company = Company::create([
                'descripcion' => 'Boutique de moda femenina...',
                'ruc' => '20601234567',
                'direccion' => 'Av. Conquistadores 789, San Isidro, Lima - Perú',
                'telefono' => '+51 987 654 321',
                'correo' => 'contacto@aeliaboutique.pe',
                'correo_notificaciones' => 'pedidos@aeliaboutique.pe',
                'ubicacion' => '<iframe src="https://maps.google.com"></iframe>',
                'horario' => 'Lunes a Sábado: 10:00 AM - 8:00 PM',
            ]);
        }

        $this->form->fill($company->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return CompanyForm::configure($schema)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $company = Company::first();
        if ($company) {
            $company->update($data);
        } else {
            Company::create($data);
        }

        Notification::make()
            ->title('Información de la Empresa guardada correctamente')
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
