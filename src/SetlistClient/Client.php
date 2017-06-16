<?php

namespace SetlistClient;

use SetlistClient\Artist;
use SetlistClient\City;

/**
 * Description of Client
 *
 * @author airibarren
 */
class Client {

    private $url;

    private $curlOptions = [];

    private $classes = [
        'artist' => 'Artist',
        'city' => 'City',
        'country' => 'Country',
    ];

    private $apis = [];


    public function __construct($url)
    {
        $this->url = $url;
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

    /**
     * Prepare the request by setting the cURL options.
     *
     * @param string $path
     * @param string $method
     * @param string $data
     *
     * @return resource a cURL handle on success, <b>FALSE</b> on errors
     */
    public function prepareRequest($path, $method = 'GET', $data = '')
    {
        $this->responseCode = null;
        $curl = curl_init();

        // General cURL options
        $this->setCurlOption(CURLOPT_VERBOSE, 0);
        $this->setCurlOption(CURLOPT_HEADER, 0);
        $this->setCurlOption(CURLOPT_RETURNTRANSFER, 1);

//        // HTTP Basic Authentication
//        if ($this->apikeyOrUsername && $this->useHttpAuth) {
//            if (null === $this->pass) {
//                $this->setCurlOption(CURLOPT_USERPWD, $this->apikeyOrUsername.':'.rand(100000, 199999));
//            } else {
//                $this->setCurlOption(CURLOPT_USERPWD, $this->apikeyOrUsername.':'.$this->pass);
//            }
//            $this->setCurlOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        }

        // Host and request options
        $this->setCurlOption(CURLOPT_URL, $this->url.$path);
//        $this->setCurlOption(CURLOPT_PORT, $this->getPort());
//        if (80 !== $this->getPort()) {
//            $this->setCurlOption(CURLOPT_SSL_VERIFYPEER, (int) $this->checkSslCertificate);
//            $this->setCurlOption(CURLOPT_SSL_VERIFYHOST, (int) $this->checkSslHost);
//            $this->setCurlOption(CURLOPT_SSLVERSION, $this->sslVersion);
//        }

        // Set the HTTP request headers
        //$httpHeader = $this->setHttpHeader($path);
        //$this->setCurlOption(CURLOPT_HTTPHEADER, $httpHeader);

        $this->unsetCurlOption(CURLOPT_CUSTOMREQUEST);
        $this->unsetCurlOption(CURLOPT_POST);
        $this->unsetCurlOption(CURLOPT_POSTFIELDS);
        switch ($method) {
            case 'POST':
                $this->setCurlOption(CURLOPT_POST, 1);
                if (isset($data)) {
                    $this->setCurlOption(CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'PUT');
                if (isset($data)) {
                    $this->setCurlOption(CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'DELETE':
                $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default: // GET
                break;
        }

        // Set all cURL options to the current cURL resource
        curl_setopt_array($curl, $this->getCurlOptions());

        return $curl;
    }

    /**
     * Set a cURL option.
     *
     * @param int   $option The CURLOPT_XXX option to set
     * @param mixed $value  The value to be set on option
     *
     * @return Client
     */
    public function setCurlOption($option, $value)
    {
        $this->curlOptions[$option] = $value;

        return $this;
    }

     /**
      * Unset a cURL option.
      *
      * @param int   $option The CURLOPT_XXX option to unset
      *
      * @return Client
      */
     public function unsetCurlOption($option)
     {
         unset($this->curlOptions[$option]);

         return $this;
     }

    /**
     * Get all set cURL options.
     *
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }
}
