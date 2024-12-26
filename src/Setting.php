<?php

namespace Dcat\Admin\ExchangeRate;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function title()
    {
        return $this->trans('exchange-rate.options.settings.title');
    }

    public function form()
    {
        $this->tags(
            'symbols',
            $this->trans('exchange-rate.options.settings.symbols')
        )->default(ExchangeRateServiceProvider::symbols())
            ->required();
    }
}
