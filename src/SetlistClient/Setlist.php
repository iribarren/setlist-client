<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Setlist
 *
 * @author airibarren
 */
class Setlist extends AbstractApi {

    public function getById($id = '', $json = true) {
        if ($geoId == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "setlist/" . $id;

        if ($json) {
            $path .= ".json";
        }

        return $this->get($path);
    }

    public function getVersion($version = '', $json = true) {
        if ($version == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "setlist/version/" . $version;

        if ($json) {
            $path .= ".json";
        }

        return $this->get($path);
    }

    public function search($artistMbid = '', $artistTmid = '', $artistName = '', $tour = '', $date = '', $year = '', $lastFm = '', $lastUpdated = '', $venueId = '', $venueName = '', $cityId = '', $cityName = '', $stateCode = '', $state = '', $countryCo = '', $page = '', $lang = '', $json = true) {

        if ($artistMbid == '' && $artistTmid == '' && $artistName == '' && $tour == '' && $date == '' && $year == '' && $lastFm == '' && $lastUpdated == '' && $venueId == '' && $venueName == '' && $cityId == '' && $cityName == '' && $stateCode == '' && $state == '' && $countryCo == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/setlists";

        if ($json) {
            $path .= ".json";
        }

        $params = ['artistMbid' => $artistMbid,
            'artistTmid' => $artistTmid,
            'artistName' => $artistName,
            'tour' => $tour,
            'date' => $date,
            //'year' => $year,
            'lastFm' => $lastFm,
            'lastUpdated' => $lastUpdated,
            'venueId' => $venueId,
            'venueName' => $venueName,
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