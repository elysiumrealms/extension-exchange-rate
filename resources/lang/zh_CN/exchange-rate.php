<?php
return [
    'labels' => [
        'ExchangeRate' => '汇率',
        'title' => '汇率设置',
    ],
    'fields' => [
        'base' => '基准货币',
        'quote' => '报价货币',
        'rate' => '汇率值',
        'updated_at' => '最后更新时间',
    ],
    'options' => [
        'tools' => [
            'refresh' => '更新汇率',
        ],
        'settings' => [
            'title' => '汇率设置',
            'symbols' => '货币符号',
        ],
        'messages' => [
            'succeeded' => '汇率更新成功',
        ]
    ],
];
