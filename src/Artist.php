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

    public function getByMbid($mbid = '')
    {
        if ($mbid == '') {
            throw new Exception("No search parameters given\n");
        }

        return $this->get("artist/" . $mbid);
    }

    public function search($mbid = '', $tmid = '', $name = '', $page = 1, $sort = 'relevance')
    {
        if ($mbid == '' && $tmid == '' && $name == '') {
            throw new Exception("No search parameters given\n");
        }

        $path = "search/artists";

        $params = [
            'mbid' => $mbid,
            'tmid' => $tmid,
            'artistName' => $name,
            'p' => $page,
            'sort' => $sort,
        ];

        $query = http_build_query($params);

        if ($query != '') {
            $path .= "?".$query;
        }

        return $this->get($path);
    }
}
