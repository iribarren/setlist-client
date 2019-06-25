<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Setlist
 *
 * @author airibarren
 */
class Setlist extends AbstractApi {

    public function getById($id = '') {
        if ($id == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "setlist/" . $id;

        return $this->get($path);
    }

    public function getVersion($version = '') {
        if ($version == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "setlist/version/" . $version;

        return $this->get($path);
    }

    public function search($artistMbid = '', $artistTmid = '', $artistName = '', $tour = '', $date = '', $year = '', $lastFm = '', $lastUpdated = '', $venueId = '', $venueName = '', $cityId = '', $cityName = '', $stateCode = '', $state = '', $countryCo = '', $page = 1, $lang = '') {

        if ($artistMbid == '' && $artistTmid == '' && $artistName == '' && $tour == '' && $date == '' && $year == '' && $lastFm == '' && $lastUpdated == '' && $venueId == '' && $venueName == '' && $cityId == '' && $cityName == '' && $stateCode == '' && $state == '' && $countryCo == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/setlists";

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

        return $this->get($path);
    }
}