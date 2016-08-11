<?php

namespace Morrelinko\SafiApi;

class Category
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function createCategory($data)
    {
        return $this->client->call('POST', 'categories', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @return string
     */
    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/categories');
    }
}

