<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'République Centrafricaine',
                'code' => 'CF',
                'phone_code' => '+236',
                'phone_format' => '## ## ## ##',
                'currency' => 'XAF',
                'flag' => '🇨🇫',
                'is_active' => true,
            ],
            [
                'name' => 'Sénégal',
                'code' => 'SN',
                'phone_code' => '+221',
                'phone_format' => '## ### ## ##',
                'currency' => 'XOF',
                'flag' => '🇸🇳',
                'is_active' => true,
            ],
            [
                'name' => 'France',
                'code' => 'FR',
                'phone_code' => '+33',
                'phone_format' => '# ## ## ## ##',
                'currency' => 'EUR',
                'flag' => '🇫🇷',
                'is_active' => true,
            ],
        ];

        foreach ($countries as $countryData) {
            Country::updateOrCreate(['code' => $countryData['code']], $countryData);
        }

        $this->command->info('✓ Pays essentiels (CF, SN, FR) créés avec succès.');
    }
}
