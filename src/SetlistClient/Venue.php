<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Venue
 *
 * @author airibarren
 */
class Venue extends AbstractApi {

    public function getById($id = '', $json = true) {
        if ($geoId == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "venue/" . $id;

        if ($json) {
            $path .= ".json";
        }

        return $this->get($path);
    }

    public function search($venueName = '', $cityId = '', $cityName = '', $stateCode = '', $state = '', $countryCo = '', $page = '', $lang = '', $json = true) {
        if ($venueName == '' && $cityId == '' && $cityName == '' && $stateCode == '' && $state == '' && $countryCo == '') {
            throw new Exception("No search parameters given\n");
        }
        $path = "search/venues";
        if ($json) {
            $path .= ".json";
        }
        $params = ['venueName' => $venueName,
            'cityId' => $cityId,
            'cityName' => $cityName,
            'stateCode' => $stateCode,
            'state' => $state,
            'countryCo' => $countryCo,
            'p' => $page,
                //'l' => $lang,
        ];
        $query = http_build_query($params);
        if ($query != '') {
            $path .= "?" . $query;
        }
        echo $path . PHP_EOL;
        return $this->get($path);
    }

}
