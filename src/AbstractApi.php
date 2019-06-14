<?php

namespace SetlistClient;

use SetlistClient\Client;

/**
 * Description of AbstractApi
 *
 * @author airibarren
 */

abstract class AbstractApi {
    /**
     * The client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Perform the client get() method.
     *
     * @param string $path
     * @param bool   $decode
     *
     * @return array
     */
    protected function get($path)
    {
        return $this->client->get($path);
    }

    /**
     * Perform the client post() method.
     *
     * @param string $path
     * @param string $data
     *
     * @return string|false
     */
    protected function post($path, $data)
    {
        return $this->client->post($path, $data);
    }

    /**
     * Perform the client put() method.
     *
     * @param string $path
     * @param string $data
     *
     * @return string|false
     */
    protected function put($path, $data)
    {
        return $this->client->put($path, $data);
    }

    /**
     * Perform the client delete() method.
     *
     * @param string $path
     *
     * @return string|false
     */
    protected function delete($path)
    {
        return $this->client->delete($path);
    }
}
