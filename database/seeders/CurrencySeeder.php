<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Live rates as of 05 Mar 2026 (base: USD) — source: open.er-api.com
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar',          'symbol' => '$',   'exchange_rate' => 1.000000],
            ['code' => 'INR', 'name' => 'Indian Rupee',        'symbol' => '₹',   'exchange_rate' => 92.203439],
            ['code' => 'EUR', 'name' => 'Euro',                'symbol' => '€',   'exchange_rate' => 0.859488],
            ['code' => 'GBP', 'name' => 'British Pound',       'symbol' => '£',   'exchange_rate' => 0.748250],
            ['code' => 'JPY', 'name' => 'Japanese Yen',        'symbol' => '¥',   'exchange_rate' => 157.122239],
            ['code' => 'AUD', 'name' => 'Australian Dollar',   'symbol' => 'A$',  'exchange_rate' => 1.415796],
            ['code' => 'CAD', 'name' => 'Canadian Dollar',     'symbol' => 'C$',  'exchange_rate' => 1.365499],
            ['code' => 'CHF', 'name' => 'Swiss Franc',         'symbol' => 'Fr',  'exchange_rate' => 0.779983],
            ['code' => 'CNY', 'name' => 'Chinese Yuan',        'symbol' => '¥',   'exchange_rate' => 6.905652],
            ['code' => 'HKD', 'name' => 'Hong Kong Dollar',    'symbol' => 'HK$', 'exchange_rate' => 7.817212],
            ['code' => 'SGD', 'name' => 'Singapore Dollar',    'symbol' => 'S$',  'exchange_rate' => 1.275048],
            ['code' => 'NZD', 'name' => 'New Zealand Dollar',  'symbol' => 'NZ$', 'exchange_rate' => 1.685560],
            ['code' => 'AED', 'name' => 'UAE Dirham',          'symbol' => 'د.إ', 'exchange_rate' => 3.672500],
            ['code' => 'SAR', 'name' => 'Saudi Riyal',         'symbol' => '﷼',   'exchange_rate' => 3.750000],
            ['code' => 'KWD', 'name' => 'Kuwaiti Dinar',       'symbol' => 'KD',  'exchange_rate' => 0.306975],
            ['code' => 'QAR', 'name' => 'Qatari Riyal',        'symbol' => 'QR',  'exchange_rate' => 3.640000],
            ['code' => 'BRL', 'name' => 'Brazilian Real',      'symbol' => 'R$',  'exchange_rate' => 5.230312],
            ['code' => 'MXN', 'name' => 'Mexican Peso',        'symbol' => 'MX$', 'exchange_rate' => 17.587834],
            ['code' => 'ZAR', 'name' => 'South African Rand',  'symbol' => 'R',   'exchange_rate' => 16.336726],
            ['code' => 'TRY', 'name' => 'Turkish Lira',        'symbol' => '₺',   'exchange_rate' => 43.978076],
            ['code' => 'RUB', 'name' => 'Russian Ruble',       'symbol' => '₽',   'exchange_rate' => 77.852626],
            ['code' => 'SEK', 'name' => 'Swedish Krona',       'symbol' => 'kr',  'exchange_rate' => 9.175733],
            ['code' => 'NOK', 'name' => 'Norwegian Krone',     'symbol' => 'kr',  'exchange_rate' => 9.635019],
            ['code' => 'DKK', 'name' => 'Danish Krone',        'symbol' => 'kr',  'exchange_rate' => 6.412729],
            ['code' => 'THB', 'name' => 'Thai Baht',           'symbol' => '฿',   'exchange_rate' => 31.541771],
            ['code' => 'MYR', 'name' => 'Malaysian Ringgit',   'symbol' => 'RM',  'exchange_rate' => 3.942272],
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah',   'symbol' => 'Rp',  'exchange_rate' => 16870.902319],
            ['code' => 'PHP', 'name' => 'Philippine Peso',     'symbol' => '₱',   'exchange_rate' => 58.467854],
            ['code' => 'PKR', 'name' => 'Pakistani Rupee',     'symbol' => '₨',   'exchange_rate' => 277.242794],
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka',    'symbol' => '৳',   'exchange_rate' => 122.148981],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::updateOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
