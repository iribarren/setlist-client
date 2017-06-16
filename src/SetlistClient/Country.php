<?php

namespace SetlistClient;

use SetlistClient\AbstractApi;

/**
 * Description of Country
 *
 * @author airibarren
 */
class Country extends AbstractApi{

    public function search($lang = '', $json = true) {
        $path = "search/countries";

        if ($json) {
            $path .= ".json";
        }

        $params = array(
                //'l' => $lang, it seems not to be working yet
        );

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?" . $query;
        }

        echo $path . PHP_EOL;

        return $this->get($path);
    }

}
