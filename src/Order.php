<?php

namespace Chinookng\SafiApi;

class Order
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * @param $orderId
     * @return array|mixed
     */
    public function get($orderId)
    {
        return $this->client->call('GET', 'orders/' . $orderId, [
            'query' => ['include' => 'user,details']
        ]);
    }

    public function getCart($uniqueId)
    {
        return $this->client->call('GET', 'carts/' . $uniqueId);
    }

    /**
     * @param $data
     * @param array $options
     * @return array|mixed
     */
    public function cartIncrementProduct($data, $options = [])
    {
        $data = array_merge(
            array_pick($data, ['user_id', 'product_id', 'quantity']),
            ['cart_type' => 'product']
        );

        $options = array_merge_recursive($options, [
            'Content-Type' => 'application/json',
            'query' => [],
            'json' => $data
        ]);

        return $this->client->call('POST', 'carts', $options);
    }

    /**
     * @param $uniqueId
     * @param $productId
     * @param $options
     * @return array|mixed
     */
    public function cartDecrementProduct($uniqueId, $productId, $options = [])
    {
        $options = array_merge_recursive($options, [
            'Content-Type' => 'application/json'
        ]);

        return $this->client->call(
            'DELETE',
            'carts/' . $uniqueId . '/products/' . $productId . '/product',
            $options
        );
    }

    /**
     * @param $data
     * @param array $options
     * @return array|mixed
     */
    public function cartIncrementOffer($data, $options = [])
    {
        $data = array_merge(
            array_pick($data, ['user_id', 'product_id', 'quantity']),
            ['cart_type' => 'offer']
        );

        $options = array_merge_recursive($options, [
            'Content-Type' => 'application/json',
            'query' => [],
            'json' => $data
        ]);

        return $this->client->call('POST', 'carts', $options);
    }

    /**
     * @param $uniqueId
     * @param $offerId
     * @param $options
     * @return array|mixed
     */
    public function cartDecrementOffer($uniqueId, $offerId, $options = [])
    {
        $options = array_merge_recursive($options, [
            'Content-Type' => 'application/json'
        ]);

        return $this->client->call(
            'DELETE',
            'carts/' . $uniqueId . '/products/' . $offerId . '/offer',
            $options
        );
    }

    /**
     * @param $orderId
     * @param $items
     * @param $options
     */
    public function updateOrderItems($orderId, $items, $options = [])
    {
        $options = array_merge_recursive($options, [
            'Content-Type' => 'application/json',
            'json' => $items
        ]);

        $this->client->call('PUT', '/orders/details', $options);
    }

    /**
     * @param $barcode
     * @return array|mixed
     */
    public function getOrderItemByBarcode($barcode)
    {
        $options = array_merge_recursive([], $options);

        return $this->client->call('GET', '/orders/details/' . $barcode, $options);
    }
}
