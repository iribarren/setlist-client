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
    public function getByGeoId($geoId = '')
    {
        if ($geoId == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "city/" . $geoId;

        return $this->get($path);
    }

    public function search($name = '', $stateCode = '', $state = '', $country = '', $page = 1, $lang = '')
    {

        if ($name == '' && $stateCode == '' && $state == '' && $country == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/cities";

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

        return $this->get($path);
    }
}
