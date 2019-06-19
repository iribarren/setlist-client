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
    private $apiKey;
    private $responseFormat;

    private $curlOptions = [];

    private $classes = [
        'artist' => 'Artist',
        'city' => 'City',
        'country' => 'Country',
        'setlist' => 'Setlist'
    ];

    private $apis = [];


    public function __construct($url, $responseFormat, $apiKey)
    {
        $this->url = $url;
        $this->responseFormat = $responseFormat;
        $this->apiKey = $apiKey;
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
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * 
     * @return string
     */
    public function getResponseFormat()
    {
        return $this->responseFormat;
    }
    
    /**
     * 
     * @param string $responseFormat
     */
    public function setResponseFormat($responseFormat)
    {
        $this->responseFormat = $responseFormat; 
    }
    
    /**
     * 
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    /**
     * 
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
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
        if (false === $response = $this->runRequest($path, 'GET')) {
            return false;
        }

        return $response;
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

        $headers = [
            'x-api-key: ' . $this->apiKey,
            'Accept: ' . $this->responseFormat,
        ];
        $this->setCurlOption(CURLOPT_HTTPHEADER, $headers);
        
        $this->setCurlOption(CURLOPT_RETURNTRANSFER, 1);

        // Host and request options
        $this->setCurlOption(CURLOPT_URL, $this->url.$path);



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