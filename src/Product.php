<?php

namespace Chinookng\SafiApi;

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
        $options = array_merge($options, [
            'query' => ['limit' => 1000]
        ]);

        $res = $this->client->call('GET', 'products', $options);

        if (isset($res->data)) {
            return $res->data;
        }

        return $res;
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
     * @param $productId
     * @param $imageFile
     * @param $filename
     * @return array|mixed
     */
    public function uploadImage($productId, $imageFile, $filename = null)
    {
        return $this->client->call('POST', 'products/' . $productId . '/image', [
            'Content-Type' => 'multipart/form-data',
            'multipart' => [
                ['name' => 'filename', 'contents' => $filename],
                ['name' => 'image', 'contents' => fopen($imageFile, 'r')]
            ]
        ]);
    }

    public function attributes()
    {
        return $this->client->call('GET', 'products/attribute', []);
    }

    /**
     * Returns the products api endpoint used by datatable
     * @return string
     */
    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/products');
    }
}
