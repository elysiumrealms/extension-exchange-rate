<?php

namespace Dcat\Admin\ExchangeRate\Http\Controllers\Tools;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\ExchangeRate\ExchangeRateServiceProvider;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RefreshExchangeRate extends AbstractTool
{
    protected $style = 'btn btn-primary waves-effect';

    public function __construct()
    {
        $title = admin_trans_option('refresh', 'tools');

        $this->title = <<<HTML
            <i class="fa fa-balance-scale"></i> $title
        HTML;
    }

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        Artisan::call('db:seed', [
            '--class' => 'ExchangeRateSeeder',
        ]);

        return $this->response()
            ->success(ExchangeRateServiceProvider::trans(
                'exchange-rate.options.messages.success',
            ))
            ->refresh();
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
