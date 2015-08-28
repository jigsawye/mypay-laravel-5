<?php

namespace Jigsawye\Mypay;

use GuzzleHttp\Client;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

interface PaymentInterface
{

    /**
     * initialize
     *
     * @param ConfigRepository $config
     * @param Request          $request
     * @param Client           $client
     */
    public function __construct(ConfigRepository $config, Request $request, Client $client);


    /**
     * 設定使用者的相關資料
     *
     * @param array $user
     *
     * @return mixed
     */
    public function user(array $user);


    /**
     * 設定訂單的 ID
     *
     * @param $orderId
     *
     * @return mixed
     */
    public function orderId($orderId);


    /**
     * 設定付款方式
     *
     * @param $method
     *
     * @return mixed
     */
    public function paymentMethod($method);


    /**
     * 設定特店 id 及 key
     *
     * @param $storeId
     * @param $storeKey
     *
     * @return mixed
     */
    public function store($storeId, $storeKey);


    /**
     * 設定產品列表
     *
     * @param array $items
     *
     * @return mixed
     */
    public function items(array $items);


    /**
     * 設定完成付款後的 URL
     *
     * @param $url
     *
     * @return mixed
     */
    public function returnUrl($url);


    /**
     * 送出請求
     *
     * @return mixed
     */
    public function send();
}
