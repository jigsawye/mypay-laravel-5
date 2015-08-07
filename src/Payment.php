<?php

namespace Jigsawye\Mypay;

use GuzzleHttp\Client;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class Payment implements PaymentInterface
{
    protected $client;

    protected $request;

    protected $initUrl;

    protected $callbackUrl;

    protected $store = [];

    protected $params = [];

    protected $mapping = [];

    public function __construct(ConfigRepository $config, Request $request, Client $client)
    {
        $this->client = $client;
        $this->request = $request;

        $this->initUrl = $config->get('mypay.domain') . 'api/initPaySystem.php';
        $this->callbackUrl = $config->get('mypay.callback');
        $this->store = $config->get('mypay.store');
        $this->mapping = $config->get('mypay.params');

        $this->params = $this->initParams();
    }

    /**
     * @return mixed
     */
    public function send()
    {
        $response = $this->client->post($this->initUrl, ['form_params' => $this->params]);

        parse_str($response->getBody(), $result);

        return $result;
    }

    /**
     * @param $storeId
     * @param $storeKey
     *
     * @return $this
     */
    public function store($storeId, $storeKey)
    {
        $this->store['id'] = $storeId;
        $this->store['key'] = $storeKey;

        return $this;
    }

    /**
     * @param array $user
     *
     * @return $this
     */
    public function user(array $user)
    {
        $params = [];

        $userId = array_get($user, 'user_id', 'user_id');
        $userName = array_get($user, 'name', false);
        $userAddress = array_get($user, 'user_address', false);
        $userPhone = array_get($user, 'user_phone', false);

        !$userName ?: $params += ['user_name' => $userName, 'user_real_name' => $userName];
        !$userAddress ?: $params += ['user_address' => $userAddress];
        !$userPhone ?: $params += ['user_phone' => $userPhone, 'user_cellphone' => $userPhone];

        $this->params['userId'] = $userId;
        $this->params += $params;

        return $this;
    }

    /**
     * @param       $orderId
     * @param array $items
     *
     * @return mixed
     */
    public function items($orderId, array $items)
    {
        $itemParams = [
            'order_id' => $orderId,
            'item' => count($items),
            'cost' => 0
        ];

        foreach ($items as $i => $item) {
            $node = [
                sprintf('i_%d_id', $i)     => $item[$this->mapping['id']],
                sprintf('i_%d_name', $i)   => $item[$this->mapping['name']],
                sprintf('i_%d_cost', $i)   => $item[$this->mapping['cost']],
                sprintf('i_%d_amount', $i) => $item[$this->mapping['amount']],
                sprintf('i_%d_total', $i)  => $item[$this->mapping['total']],
            ];

            $itemParams['cost'] += $item['total'];
            $itemParams += $node;
        }

        $this->params += $itemParams;

        return $this;
    }

    /**
     * @return array
     */
    private function initParams()
    {
        return [
            'store_id' => $this->store['id'],
            'store_key' => $this->store['key'],
            'ip' => $this->request->getClientIp(),
            'returl' => $this->callbackUrl,
            'charset' => 'UTF-8',
            'user_id' => 'user_id',
            'pfn' => '0',
        ];
    }
}
