<?php
require_once __DIR__ . '/../vendor/autoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$client = new SetlistClient\Client("https://api.setlist.fm/rest/0.1/");

try {
    $result = $client->artist->search('','','Iron Maiden');
    print_r($result);
    $result = $client->artist->getByMbid();
print_r($result);
} catch (Exception $e) {
    die($e->getMessage());
}





