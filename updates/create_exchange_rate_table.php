<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRateTable extends Migration
{
    public function getConnection()
    {
        return config('database.connection') ?: config('database.default');
    }

    public function up()
    {
        if (Schema::hasTable('exchange_rates'))
            return;

        Schema::create(
            'exchange_rates',
            function (Blueprint $table) {
                $table->id();
                $table->string('base', 10)
                    ->comment('基準貨幣');
                $table->string('quote', 10)
                    ->comment('報價貨幣');
                $table->decimal('rate', 15, 6)
                    ->comment('匯率值');
                $table->timestamp('updated_at')
                    ->useCurrent()
                    ->comment('最後更新時間');

                // 保證每個幣別組合只有一個匯率值
                $table->unique(['base', 'quote']);
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
