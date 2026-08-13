<?php

namespace App\Filament\Resources\BankAccounts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BankAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('bank_name')
                    ->label('Banco / Billetera Digital')
                    ->placeholder('Ej. BCP, BBVA, Interbank, Yape, Plin')
                    ->required(),
                TextInput::make('account_type')
                    ->label('Tipo de Cuenta')
                    ->placeholder('Ej. Ahorros Soles, Corriente, Billetera Movil'),
                TextInput::make('account_number')
                    ->label('Número de Cuenta / Teléfono')
                    ->required(),
                TextInput::make('cci')
                    ->label('Código Interbancario (CCI)'),
                TextInput::make('holder_name')
                    ->label('Titular de la Cuenta')
                    ->required(),
                FileUpload::make('qr_code')
                    ->label('Código QR (Yape / Plin / BCP)')
                    ->image()
                    ->directory('bank-qrs')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Cuenta Activa')
                    ->default(true),
            ]);
    }
}
