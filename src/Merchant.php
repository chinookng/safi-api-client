<?php

namespace Chinookng\SafiApi;

class Merchant
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }
    
    /**
     * finds a merchant
     * @param $options
     * @return array|mixed
     */
    public function find()
    {
        return $this->client->call('GET', 'merchants', $options);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        return $this->client->call('POST', 'merchants', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $merchantId
     * @return array|mixed
     */
    public function get($merchantId)
    {
        return $this->client->call('GET', 'merchants/' . $merchantId);
    }

    /**
     * @param $merchantId
     * @param $data
     * @return array|mixed
     */
    public function update($merchantId, $data)
    {
        return $this->client->call('PUT', 'merchants/' . $merchantId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    public function ordersDatatableUrl($shopId)
    {
        return $this->client->buildUrl('datatables/merchant/' . $shopId . '/orders');
    }
}
