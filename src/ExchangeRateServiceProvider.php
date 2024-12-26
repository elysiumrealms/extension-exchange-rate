<?php

namespace Dcat\Admin\ExchangeRate;

use Dcat\Admin\Extend\ServiceProvider;

class ExchangeRateServiceProvider extends ServiceProvider
{
	protected $menu = [
		[
			'parent' => 2,
			'title' => 'Exchange Rates',
			'uri'   => 'auth/exchange-rates',
		],
	];

	public static function symbols()
	{
		return static::setting(
			'symbols',
			[
				'USD',
				'EUR',
				'JPY',
				'CNY',
				'TWD',
				'PHP',
				'BRL',
				'INR',
				'MXN',
			]
		);
	}

	/**
	 * 获取種子文件目錄.
	 *
	 * @return string
	 */
	final public function getSeederPath()
	{
		return $this->path('database/seeders');
	}

	/**
	 * {@inheritDoc}
	 */
	public function publishable()
	{
		$this->publishes([
			$this->getLangPath() => resource_path('lang'),
			$this->getSeederPath() => database_path('seeders'),
		], $this->getName());
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
