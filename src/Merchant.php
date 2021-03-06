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
     * @param $shopId
     * @param $options
     * @return array|mixed
     */
    public function get($shopId, $options = [])
    {
        return $this->client->call('GET', 'merchants/' . $shopId, $options);
    }

    /**
     * @param $shopId
     * @param $data
     * @return array|mixed
     */
    public function update($shopId, $data)
    {
        return $this->client->call('PUT', 'merchants/' . $shopId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    public function addStaff($shopId, $userId)
    {
        return $this->client->call(
            'POST',
            'merchants/' . $shopId . '/users/' . $shopId
        );
    }

    public function removeStaff($shopId, $userId)
    {
        return $this->client->call(
            'DELETE',
            'merchants/' . $shopId . '/users/' . $userId
        );
    }

    public function setStaffs($shopId, $staffs = [])
    {
        return $this->client->call('POST', 'merchants/' . $shopId . '/users', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['users_id' => $staffs]
        ]);
    }

    public function ordersDatatableUrl($shopId)
    {
        return $this->client->buildUrl('datatables/merchant/' . $shopId . '/orders');
    }
}
