<?php

namespace SetlistClient;

use SetlistClient\Artist;

/**
 * Description of Client
 *
 * @author airibarren
 */
class Client {
    private $classes = [
        'artist' => 'Artist',
    ];

    private $apis = [];


    public function __construct()
    {
    }

    /**
     * PHP getter magic method.
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return Api\AbstractApi
     */
    public function __get($name)
    {
        return $this->api($name);
    }

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return Api\AbstractApi
     */
    public function api($name)
    {
        if (!isset($this->classes[$name])) {
            throw new \InvalidArgumentException();
        }
        if (isset($this->apis[$name])) {
            return $this->apis[$name];
        }
        $class = 'SetlistClient\\'.$this->classes[$name];
        $this->apis[$name] = new $class($this);

        return $this->apis[$name];
    }

    /**
     * HTTP GETs a json $path and tries to decode it.
     *
     * @param string $path
     *
     * @return array|string|false
     */
    public function get($path)
    {
        if (false === $json = $this->runRequest($path, 'GET')) {
            return false;
        }

        return $json;
    }

    /**
     * @codeCoverageIgnore Ignore due to untestable curl_* function calls.
     *
     * @param string $path
     * @param string $method
     * @param string $data
     *
     * @throws \Exception If anything goes wrong on curl request
     *
     * @return false|string
     */
    protected function runRequest($path, $method = 'GET', $data = '')
    {
        $curl = $this->prepareRequest($path, $method, $data);

        $response = curl_exec($curl);
        $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        if (curl_errno($curl)) {
            $e = new \Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);
            throw $e;
        }
        curl_close($curl);

        return $response;
    }
}
