<?php

namespace Morrelinko\SafiApi;

class Product
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets product lists
     *
     * @param $options
     * @return array|mixed
     */
    public function all($options = [])
    {
        return $this->client->call('GET', 'products', $options);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        return $this->client->call('POST', 'products', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $productId
     * @param $data
     * @return array|mixed
     */
    public function update($productId, $data)
    {
        return $this->client->call('PUT', 'products/' . $productId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $productId
     * @return array|mixed
     */
    public function get($productId)
    {
        return $this->client->call('GET', 'products/' . $productId);
    }

    /**
     * @return string
     */
    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/products');
    }
}
