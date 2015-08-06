<?php

return [
    /**
     * 金流 API 的 Domain
     */
    'domain' => '',

    /**
     * 使用者進行付款後的 Callback Url，須使用 Get 方式接收
     * 例如：http:://yourdomain.com/callback
     */
    'callback' => '',


    /**
     * 特店的 ID 及 Key
     */
    'store' => [
        'id' => '',
        'key' => '',
    ],

    /**
     * 傳遞給 API 的參數對應，若你給予的物品欄位與預設的不同
     * 請在此做對應
     */
    'params' => [
        'id'     => 'id',
        'name'   => 'name',
        'cost'   => 'cost',
        'amount' => 'amout',
        'total'  => 'total',
    ]
];
