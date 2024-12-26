<?php

namespace Dcat\Admin\ExchangeRate;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->tags('symbols')
            ->default(ExchangeRateServiceProvider::symbols())
            ->required();
    }
}
