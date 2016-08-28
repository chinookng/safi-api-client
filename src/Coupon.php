<?php

namespace Chinookng\SafiApi;

class Coupon
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    public function all()
    {
        return $this->find();
    }

    /**
     * Gets all offers
     * @return array|mixed
     */
    public function find($options = [])
    {
        $options = array_merge($options, []);

        return $this->client->call('GET', 'coupons', $options);
    }

    /**
     * @param $code
     * @param $options
     * @return array|mixed
     */
    public function get($code, $options)
    {
        return $this->client->call('GET', 'coupons/' . $code, $options);
    }

    /**
     * @param $data
     * @param $options
     * @return array|mixed
     */
    public function create($data, $options = [])
    {
        $options = array_merge($options, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);

        return $this->client->call('POST', 'coupons', $options);
    }

    /**
     * @param $code
     * @param $data
     * @param $options
     * @return array|mixed
     */
    public function update($code, $data, $options = [])
    {
        $options = array_merge($options, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);

        return $this->client->call('PUT', 'coupons/' . $code, $options);
    }

    public function datatableUrl($code)
    {
        return $this->client->buildUrl('datatables/coupons');
    }
}
