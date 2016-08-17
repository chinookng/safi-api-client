<?php

namespace Chinookng\SafiApi;

use Morrelinko\SafiApi\Exception\SafiApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use RuntimeException;

/**
 * <pre><code>
 *
 *  $safiApi = new SafiApi([
 *      'baseUrl' => 'https://api.safi.ng',
 *      'token' => session('access_token'),
 *      'client_id' => env('CLIENT_ID'),
 *      'client_secret' => env('CLIENT_SECRET')
 *  ]);
 *
 *  $safiApi->products->create($data);
 *
 *  $safiApi->users->get($id);
 * </code></pre>
 *
 * @property Product $products
 * @property Subscription $subscriptions
 * @property User $users
 * @package App\Library\SafiApi
 */
class SafiApi
{
    /**
     * @param array $credentials
     * @return array|mixed
     */
    public function authenticate($credentials = [])
    {
        $credentials = array_merge([
            'email' => null,
            'password' => null
        ], $credentials);

        return $this->call('POST', 'oauth/access_token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => env('SAFI_API_ID'),
                'client_secret' => env('SAFI_API_SECRET'),
                'username' => $credentials['email'],
                'password' => $credentials['password']
            ]
        ], $this->createAuthenticationClient());
    }

    /**
     * @param string $appends
     * @return string
     */
    public function buildUrl($appends = '/')
    {
        return url(env('API_URL') . 'v1/' . trim($appends, '/'));
    }

    public function call($method, $url, $options = [], $client = null)
    {
        if ($client === null) {
            $client = $this->createResourceClient();
        }

        try {
            $response = $client->request($method, $url, $options);
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if (isset($data->data) && (is_array($data->data) || is_object($data->data))) {
                return $data->data;
            }
        } catch (ClientException $e) {
            throw SafiApiException::clientException($e);
        } catch (ServerException $e) {
            throw SafiApiException::serverException($e);
        }

        return $data;
    }

    protected function client()
    {
        return $this->createResourceClient();
    }

    protected function createResourceClient()
    {
        $client = new Client([
            'base_uri' => url(env('API_URL') . 'v1/'),
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);

        return $client;
    }

    protected function createAuthenticationClient()
    {
        $client = new Client([
            'base_uri' => url(env('API_URL'))
        ]);

        return $client;
    }

    /**
     * @param $name
     * @return User|Subscription|Product|Schedule|Offer|Location|Category|Order
     */
    function __get($name)
    {
        switch ($name) {
            case 'products':
                return new Product($this);
            case 'subscriptions':
                return new Subscription($this);
            case 'users':
                return new User($this);
            case 'schedules':
                return new Schedule($this);
            case 'offers':
                return new Offer($this);
            case 'location':
                return new Location($this);
            case 'categories':
                return new Category($this);
            case 'orders':
                return new Order($this);
        }

        throw new RuntimeException(
            'Trying to access undefined property '
            . __CLASS__ . '::$' . $name
        );
    }
}
