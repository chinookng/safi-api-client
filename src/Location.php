<?php

namespace Chinookng\SafiApi;

class Location
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * @return array|mixed
     */
    public function countries()
    {
        return $this->client->call('GET', 'countries');
    }

    public function updateCountry($countryId, $data)
    {
        return $this->client->call('PUT', 'countries/' . $countryId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @return array|mixed
     */
    public function states()
    {
        return $this->client->call('GET', 'states');
    }

    /**
     * @param $country
     * @return mixed
     */
    public function statesFor($country)
    {
        return $this->client->call('GET', 'countries/' . $country, [
            'query' => ['include' => 'states']
        ])->states;
    }

    /**
     * @param $stateId
     * @param $data
     * @return array|mixed
     */
    public function updateState($stateId, $data)
    {
        return $this->client->call('PUT', 'states/' . $stateId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @return array|mixed
     */
    public function cities()
    {
        return $this->client->call('GET', 'cities');
    }

    /**
     * @param $state
     * @return mixed
     */
    public function citiesFor($state)
    {
        return $this->client->call('GET', 'states/' . $state, [
            'query' => ['include' => 'cities']
        ])->cities;
    }

    /**
     * @param $cityId
     * @param $data
     * @return array|mixed
     */
    public function updateCity($cityId, $data)
    {
        return $this->client->call('PUT', 'cities/' . $cityId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }
}
