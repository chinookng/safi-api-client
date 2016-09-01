<?php

namespace Chinookng\SafiApi;

class Schedule
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets all the collection & delivery time schedules
     * @return array|mixed
     */
    public function all()
    {
        return $this->client->call('GET', 'admin_times');
    }

    public function get()
    {
        return null;
    }

    public function timeslots()
    {
        return $this->client->call('GET', 'timeslots');
    }

    public function updateCollectionTime($id, $data)
    {
        return $this->client->call('times/collections/' . $id, $data);
    }

    public function updateDeliveryTime($id, $data)
    {
        return $this->client->call('times/deliveries/' . $id, $data);
    }

    public function dailySchedules()
    {
        return $this->client->call('GET', 'admin_times');
    }
}
