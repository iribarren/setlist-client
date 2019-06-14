<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Country
 *
 * @author airibarren
 */
class Country extends AbstractApi{

    public function search($lang = '') {
        $path = "search/countries";

        $params = array(
                //'l' => $lang, it seems not to be working yet
        );

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?" . $query;
        }

        return $this->get($path);
    }

}
