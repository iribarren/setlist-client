<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Country
 *
 * @author airibarren
 */
class Country extends AbstractApi{

    public function search() {
        $path = "search/countries";

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?" . $query;
        }

        return $this->get($path);
    }

}
