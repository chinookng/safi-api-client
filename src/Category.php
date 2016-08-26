<?php

namespace Chinookng\SafiApi;

class Category
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $options
     * @return array|mixed
     */
    public function all($options = [])
    {
        $options = array_merge([], $options);

        return $this->client->call('GET', 'categories', $options);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        return $this->client->call('POST', 'categories', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $categoryId
     * @param $data
     * @return array|mixed
     */
    public function update($categoryId, $data)
    {
        return $this->client->call('POST', '/categories/' . $categoryId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @return string
     */
    public function dataTable()
    {
        return $this->client->buildUrl('datatables/admin/categories');
    }
}
