<?php

namespace Morrelinko\SafiApi;

class Offer
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets all offers
     * @return array|mixed
     */
    public function all()
    {
        return $this->client->call('GET', 'offers');
    }

    /**
     * @param $id
     * @param $options
     * @return array|mixed
     */
    public function get($id, $options)
    {
        return $this->client->call('GET', 'offers/' . $id, $options);
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
            'json' => ['offers' => $data]
        ]);

        return $this->client->call('POST', 'offers', $options);
    }

    /**
     * @param $id
     * @param $data
     * @param $options
     * @return array|mixed
     */
    public function update($id, $data, $options = [])
    {
        $options = array_merge($options, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);

        return $this->client->call('PUT', 'offers/' . $id, $options);
    }
}
