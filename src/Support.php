<?php

namespace Chinookng\SafiApi;

class Support
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets all the collection & delivery time schedules
     * @param $options
     * @return array|mixed
     */
    public function find($options = [])
    {
        // return $this->client->call('GET', 'admin_times');
    }

    public function categories($options = [])
    {
        return $this->client->call('GET', 'tickets_categories', $options);
    }
}
