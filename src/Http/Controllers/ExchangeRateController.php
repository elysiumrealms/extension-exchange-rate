<?php

namespace Dcat\Admin\ExchangeRate\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\ExchangeRate\Models\ExchangeRate;
use Dcat\Admin\ExchangeRate\ExchangeRateServiceProvider;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Http\Controllers\AdminController;

class ExchangeRateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(
            new ExchangeRate(),
            function (Grid $grid) {
                $grid->export()->xlsx();
                $grid->disableRowSelector();
                $grid->disableDeleteButton();
                switch (true) {
                    case Admin::user()->can('exchange-rate-edit'):
                        $grid->disableActions();
                        $grid->disableCreateButton();
                        break;
                    default:
                        break;
                }

                $grid->column('base')
                    ->sortable();
                $grid->column('quote')
                    ->sortable();
                $grid->column('rate')
                    ->sortable();
                $grid->column('updated_at')
                    ->sortable();

                $grid->actions(function (Actions $actions) {
                    $actions->disableDelete();
                    $actions->disableView();
                });

                $grid->quickSearch(['base', 'quote']);

                // append RefreshExchangeRate button
                $grid->tools(function (Grid\Tools $tools) {
                    switch (true) {
                        case Admin::user()->can('exchange-rate-edit'):
                            $tools->append(Tools\RefreshExchangeRate::make());
                        default:
                            break;
                    }
                });

                $symbols = ExchangeRateServiceProvider::symbols();

                $grid->selector(
                    function (Grid\Tools\Selector $selector) use ($symbols) {
                        $selector->select(
                            'base',
                            array_combine($symbols, $symbols)
                        );

                        $selector->select(
                            'quote',
                            array_combine($symbols, $symbols)
                        );
                    }
                );

                $grid->model()->whereColumn('base', '!=', 'quote');
            }
        );
    }
}
