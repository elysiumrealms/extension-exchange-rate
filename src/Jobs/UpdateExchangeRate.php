<?php

namespace Dcat\Admin\ExchangeRate\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

use Dcat\Admin\ExchangeRate\ExchangeRateServiceProvider;

class UpdateExchangeRate implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (ExchangeRateServiceProvider::instance()->disabled())
            return;

        Artisan::call('db:seed', ['--class' => 'ExchangeRateSeeder']);
    }
}
