<?php

use Dcat\Admin\ExchangeRate\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get(
    'auth/exchange-rates',
    Controllers\ExchangeRateController::class . '@index'
);
