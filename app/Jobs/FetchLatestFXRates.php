<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FX;
use DB;
use Illuminate\Support\Facades\Http;
use App\Models\CurrencyRate;
use App\Modles\Currency;

class FetchLatestFXRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currencies;
    protected $url;
    protected $api_key;

    // TODO: Create a scheduled job using: https://laravel.com/docs/8.x/scheduling#scheduling-queued-jobs
    // TODO: Add supervisor for queue to work: https://laravel.com/docs/8.x/queues#supervisor-configuration

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currencies = FX::getAllCurrencies(false);
        $this->url = config('fx-rates.exchange_rate_latest_url');
        $this->api_key = config('fx-rates.exhange_rates_api_key'); 
    }

    protected function generateURL($base_currency) {
        return str_replace(['%api-key%', '%base_currency%'], [$this->api_key, $base_currency], $this->url);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $all_codes = $this->currencies->map(fn($item) => $item->code);
        
        foreach($this->currencies as $base_currency) {
            $open_fx_rates = Http::get($this->generateURL($base_currency->code))->onError(fn($errors) => Log::warning($errors));
        
            if($open_fx_rates->successful()) {
                $data = $open_fx_rates->json();
                $unixtimestamp = $data['time_last_update_unix'];  // this is the last rates upadate on OpenExchangeRates (not the time of the request!)
                $base = $data['base_code']; // same as $code
                $fx_rates = $data['conversion_rates'];

                DB::beginTransaction();

                try {
                    foreach($fx_rates as $target => $rate) {
                        if($target === $base) {
                            continue;
                        }

                        if($all_codes->contains($target)) {
                            $exists = CurrencyRate::where([
                                ['base', $base],
                                ['target', $target]
                            ])->exists();
                            
                            if($exists) {
                                CurrencyRate::where([
                                    ['base', $base],
                                    ['target', $target]
                                ])->update(['fx_rate' => $rate, 'updated_at' => $unixtimestamp]);
                            } else {
                                CurrencyRate::create([
                                    'base_currency_id' => $base_currency->id,
                                    'base' => $base, 
                                    'target' => $target,
                                    'fx_rate' => $rate, 
                                    'created_at' => time(), // TODO: Why the fuck is only current YEAR saved in created_at instead of unixtimestmap??? Very retarded issue...it's probably something simple...
                                    'updated_at' => $unixtimestamp
                                ]);
                            }
                        }
                    }

                    DB::commit();
                } catch(\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }
        }
    }
}
