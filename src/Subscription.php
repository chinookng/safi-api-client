<?php

namespace Morrelinko\SafiApi;

class Subscription
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets product lists
     *
     * @return array|mixed
     */
    public function find()
    {
        return $this->client->call('GET', 'subscriptions');
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function get($id)
    {
        return $this->client->call('GET', 'subscriptions/' . $id);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        return $this->client->call('POST', 'subscriptions', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $subscriptionId
     * @param $data
     * @return array|mixed
     */
    public function update($subscriptionId, $data)
    {
        return $this->client->call('PUT', 'subscriptions/' . $subscriptionId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * Returns the products api endpoint used by datatable
     * @return string
     */
    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/subscriptions');
    }
}
