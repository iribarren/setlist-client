<?php

namespace SetlistClient;

use Exception;
use SetlistClient\AbstractApi;

/**
 * Description of City
 *
 * @author airibarren
 */
class City extends AbstractApi{
    public function getByGeoId($geoId = '', $json = true)
    {
        if ($geoId == '') {
            throw new Exception("No search parameters given\n");
        }

        return $this->get("city/" . $geoId . ".json");
    }

    public function search($name = '', $stateCode = '', $state = '', $country = '', $page = '', $lang = '',$json = true)
    {

        if ($name == '' && $stateCode == '' && $state == '' && $country == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/cities";

        if ($json) {
            $path .= ".json";
        }

        $params = array(
            'name' => $name,
            'stateCode' => $state,
            'state' => $state,
            'country' => $country,
            'p' => $page,
            //'l' => $lang, it seems not to be working yet
        );

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?".$query;
        }

        echo $path . PHP_EOL;

        return $this->get($path);
    }
}
