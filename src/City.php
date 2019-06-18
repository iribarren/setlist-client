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

    public function search($name = '', $stateCode = '', $state = '', $country = '', $page = 1, )
    {

        if ($name == '' && $stateCode == '' && $state == '' && $country == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/cities";

        $params = [
            'name' => $name,
            'state' => $state,
            'stateCode' => $stateCode,
            'country' => $country,
            'p' => $page,
            
        ];

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?".$query;
        }

        return $this->get($path);
    }
}
