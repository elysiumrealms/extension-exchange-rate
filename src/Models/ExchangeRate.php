<?php

namespace Dcat\Admin\ExchangeRate\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'exchange_rates';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base',
        'quote',
        'rate',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include base.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $base
     * @param string $quote
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBase($query, $base, $quote)
    {
        return $query->where('base', $base)
            ->where('quote', $quote);
    }
}
