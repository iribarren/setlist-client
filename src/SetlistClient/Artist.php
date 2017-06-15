<?php
namespace SetlistClient;

use Exception;
use SetlistClient\AbstractApi;

/**
 * Description of Artist
 *
 * @author airibarren
 */
class Artist extends AbstractApi
{

    public function getByMbid($mbid = '', $json = true)
    {
        if ($mbid == '') {
            throw new Exception("No search parameters given\n");
        }

        return $this->get("artist/" . $mbid . ".json");
    }

    public function search($mbid = '', $tmid = '', $name = '', $page = '', $json = true)
    {
        if ($mbid == '' && $tmid == '' && $name == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/artists";

        if ($json) {
            $path .= ".json";
        }

        $params = array(
            'mbid' => $mbid,
            'tmid' => $tmid,
            'artistName' => $name,
            'p' => $page,
        );

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?".$query;
        }

        echo $path . PHP_EOL;

        return $this->get($path);
    }
}
