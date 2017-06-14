<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Artist
 *
 * @author airibarren
 */
class Artist extends AbstractApi {

    public function getByMbid($mbid) {
        return $this->get("artist/" . $mbid);
    }

    public function searchByName($name) {
        return $this->get("search/artists/" . $name);
    }

}
