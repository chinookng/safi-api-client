<?php

namespace Chinookng\SafiApi;

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
    public function find($options = [])
    {
        $options = array_merge($options, []);

        return $this->client->call('GET', 'offers', $options);
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

    /**
     * @param $offerId
     * @param $imageFile
     * @param null $filename
     * @return array|mixed
     */
    public function uploadImage($offerId, $imageFile, $filename = null)
    {
        return $this->client->call('POST', 'offers/' . $offerId . '/image', [
            'Content-Type' => 'multipart/form-data',
            'multipart' => [
                ['name' => 'filename', 'contents' => $filename],
                ['name' => 'image', 'contents' => fopen($imageFile, 'r')]
            ]
        ]);
    }
}
