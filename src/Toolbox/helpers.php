<?php

if (!function_exists('array_pick')) {
    /**
     * @param $array
     * @param $keys
     * @return array
     */
    function array_pick($array, $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }
}
