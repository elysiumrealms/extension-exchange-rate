<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Dcat\Admin\ExchangeRate\ExchangeRateServiceProvider;
use Dcat\Admin\ExchangeRate\Models\ExchangeRate;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Avaliable Symbols
     * 
     * @var string[]
     */
    protected $symbols;

    /**
     * 
     */
    public function __construct()
    {
        $this->symbols = ExchangeRateServiceProvider::symbols();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Loop through the rates and save them to the database
        collect($this->symbols)
            ->each(function ($base) {
                $quotes = collect($this->symbols);
                $response = $this->request($base, $quotes);
                collect($response['rates'])
                    ->each(function ($rate, $quote) use ($base) {
                        ExchangeRate::updateOrCreate([
                            'base' => $base,
                            'quote' => $quote,
                        ], [
                            'rate' => $rate,
                            'updated_at' => now(),
                        ]);
                    });
            });
    }

    /**
     * Request the exchange rates from the API.
     *
     * @param string $base
     * @param \Illuminate\Support\Collection $quotes
     * @return array
     */
    protected function request($base, $quotes)
    {
        $request = function ($file) {
            try {
                $response = Http::get(
                    'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api'
                        . "@latest/v1/currencies/$file"
                )->json();
                file_put_contents(
                    storage_path(implode('/', ['app', $file])),
                    json_encode($response)
                );
                return $response;
            } catch (Exception $e) {
                echo "Using cached {$file} exchange rates." . PHP_EOL;
                return (array) json_decode(file_get_contents(
                    storage_path(implode('/', ['app', $file]))
                ));
            }
        };

        $response = $request(strtolower($base) . '.min.json');

        // Convery all keys to uppercase and remap to rates array.
        $rates = collect($response[strtolower($base)])
            ->mapWithKeys(function ($rate, $quote) {
                return [strtoupper($quote) => $rate];
            });
        return ['rates' => $rates->only($quotes)->toArray()];
    }
}
