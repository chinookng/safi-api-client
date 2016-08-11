<?php

namespace Morrelinko\SafiApi;

class User
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
        return $this->client->call('GET', 'users');
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
        $this->buildAddress($data, 'home_address');
        $this->buildAddress($data, 'work_address');
        $this->buildAddress($data, 'other_address');

        return $this->client->call('PUT', 'users/' . $userId, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ]);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function create($data)
    {
        $this->buildAddress($data, 'home_address');
        $this->buildAddress($data, 'work_address');
        $this->buildAddress($data, 'other_address');

        return $this->client->call('POST', 'users', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
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

    protected function buildAddress(&$data, $name)
    {
        $address = implode('###', [
            isset($data[$name . '_street']) ? $data[$name . '_street'] : '',
            isset($data[$name . '_number']) ? $data[$name . '_number'] : '',
            isset($data[$name . '_landmark']) ? $data[$name . '_landmark'] : '',
            isset($data[$name . '_city']) ? $data[$name . '_city'] : '',
            isset($data[$name . '_state']) ? $data[$name . '_state'] : '',
            isset($data[$name . '_country']) ? $data[$name . '_country'] : ''
        ]);

        $data[$name] = $address;

        unset(
            $data[$name . '_street'],
            $data[$name . '_number'],
            $data[$name . '_landmark'],
            $data[$name . '_city'],
            $data[$name . '_state'],
            $data[$name . '_country']
        );
    }
}
