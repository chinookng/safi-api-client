<?php

namespace Chinookng\SafiApi;

class Payment
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
    public function get($id, $options = [])
    {
        return $this->client->call('GET', 'payments/' . $id, $options);
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

        return $this->client->call('POST', 'payments', $options);
    }

    /**
     * @param $code
     * @param $data
     * @param $options
     * @return array|mixed
     */
    public function update($paymentId, $data, $options = [])
    {
        $options = array_merge($options, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);

        return $this->client->call('PUT', 'payments/' . $paymentId, $options);
    }

    public function getReconciliationHistory($paymentId, $options = [])
    {
        return $this->client->call('GET', 'payments/reconciliation/history/' . $paymentId, $options);
    }

    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/coupons');
    }
}
