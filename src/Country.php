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

        return $this->get($path);
    }

}
