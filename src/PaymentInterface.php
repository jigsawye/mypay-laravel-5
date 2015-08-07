<?php

namespace Jigsawye\Mypay;

use GuzzleHttp\Client;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

interface PaymentInterface
{
    public function __construct(ConfigRepository $config, Request $request, Client $client);

    public function user(array $user);

    public function store($storeId, $storeKey);

    public function items($orderId, array $items);

    public function send();
}