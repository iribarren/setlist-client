<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Venue
 *
 * @author airibarren
 */
class Venue extends AbstractApi {

    public function getById($id = '') {
        if ($geoId == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "venue/" . $id;
        
        return $this->get($path);
    }

    public function search($venueName = '', $cityId = '', $cityName = '', $stateCode = '', $state = '', $countryCo = '', $page = 1, $lang = '') {
        if ($venueName == '' && $cityId == '' && $cityName == '' && $stateCode == '' && $state == '' && $countryCo == '') {
            throw new Exception("No search parameters given\n");
        }
        $path = "search/venues";
        
        $params = ['venueName' => $venueName,
            'cityId' => $cityId,
            'cityName' => $cityName,
            'stateCode' => $stateCode,
            'state' => $state,
            'countryCo' => $countryCo,
            'p' => $page,
        ];

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?" . $query;
        }

        return $this->get($path);
    }
}
