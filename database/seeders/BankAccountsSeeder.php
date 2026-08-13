<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'bank_name' => 'BCP - Banco de Crédito del Perú',
                'account_type' => 'Cuenta Ahorros Soles',
                'account_number' => '193-98765432-0-12',
                'cci' => '002-193-0098765432012-14',
                'holder_name' => 'AELIA BOUTIQUE S.A.C.',
                'qr_code' => null,
                'is_active' => true,
            ],
            [
                'bank_name' => 'Yape',
                'account_type' => 'Billetera Digital',
                'account_number' => '987 654 321',
                'cci' => null,
                'holder_name' => 'Aelia Boutique',
                'qr_code' => null,
                'is_active' => true,
            ],
            [
                'bank_name' => 'Plin (BBVA / Interbank / Scotiabank)',
                'account_type' => 'Billetera Digital',
                'account_number' => '987 654 321',
                'cci' => null,
                'holder_name' => 'Aelia Boutique',
                'qr_code' => null,
                'is_active' => true,
            ],
            [
                'bank_name' => 'BBVA',
                'account_type' => 'Cuenta Corriente Soles',
                'account_number' => '0011-0123-0100045678-90',
                'cci' => '011-123-00010004567890-12',
                'holder_name' => 'AELIA BOUTIQUE S.A.C.',
                'qr_code' => null,
                'is_active' => true,
            ],
        ];

        foreach ($accounts as $acc) {
            BankAccount::create($acc);
        }
    }
}
