<?php

namespace Chinookng\SafiApi;

class User
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets product lists
     * @param $options
     * @return array|mixed
     */
    public function find($options = [])
    {
        return $this->client->call('GET', 'users', $options);
    }

    /**
     * Gets user associated with access token
     * @return array|mixed
     */
    public function me()
    {
        return $this->client->call('GET', 'users/profile');
    }

    /**
     * Gets a single user by ID
     * @param $id
     * @param $options
     * @return array|mixed
     */
    public function get($id, $options = [])
    {
        $options = array_merge([], $options);
        return $this->client->call('GET', 'users/' . $id, $options);
    }

    /**
     * Update user
     * @param $userId
     * @param $data
     * @return array|mixed
     */
    public function update($userId, $data)
    {
        $userData = array_pick($data, [
            'firstname', 'lastname', 'mobile', 'email', 'password'
        ]);

        $userAddresses = isset($data['addresses'])
            ? $data['addresses']
            : [];

        $response = $this->client->call('PUT', 'users/' . $userId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $userData
        ]);

        if (isset($data['addresses'])) {
            foreach ($userAddresses as $label => $address) {
                if (isset($address['id'])) {
                    $this->updateAddress($address['id'], array_pick($address, [
                        'apartment_number', 'street', 'landmark', 'city_id', 'state_id', 'country_id'
                    ]));
                } else {
                    $this->createAddress($userId, array_pick($address, [
                        'apartment_number', 'street', 'landmark', 'city_id', 'state_id', 'country_id'
                    ]));
                }
            }
        }

        return $response;
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        $userData = array_pick($data, [
            'firstname', 'lastname', 'mobile', 'email', 'password'
        ]);

        $tmpAddress = array_pick($data, [
            'address_number', 'address_street', 'address_landmark',
            'address_city', 'address_state', 'address_country'
        ]);

        $addressData = ['label' => 'Address'];
        foreach ($tmpAddress as $key => $value) {
            $addressData[str_replace('address_', '', $key)] = $value;
        }

        $user = $this->client->call('POST', 'users', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $userData
        ]);

        $address = $this->client->call('POST', 'users/' . $user->id . '/addresses', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $addressData
        ]);

        return array_merge($user, [
            'addresses' => $address
        ]);
    }

    public function createAddress($userId, $address)
    {
        $this->client->call('POST', 'users/' . $userId . '/addresses', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $address
        ]);
    }

    public function updateAddress($addressId, $address)
    {
        $this->client->call('PUT', 'addresses/' . $addressId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $address
        ]);
    }

    /**
     * Returns the users api endpoint used by datatable
     * @return string
     */
    public function datatableUrl()
    {
        return $this->client->buildUrl('datatables/admin/users');
    }
}
