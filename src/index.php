<?php
require_once __DIR__ . '/../vendor/autoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = "https://api.setlist.fm/rest/1.0/";
$apiKey = "YOUR_SETLISTFM_API_KEY";
$responseFormat = 'application/json';

$client = new SetlistClient\Client($url, $responseFormat, $apiKey);

try {
    $result = $client->artist->search('','','Iron Maiden');
    print_r($result);
//  $result = $client->artist->getByMbid("ca891d65-d9b0-4258-89f7-e6ba29d83767");
//  print_r($result);
//  $result = $client->city->search("Vitoria");
//  print_r($result);
//  $result = $client->city->getByGeoId("3104499");
//  print_r($result);
//  $result = $client->country->search();
//  print_r($result);
//    $result = $client->setlist->search("ca891d65-d9b0-4258-89f7-e6ba29d83767");
//    print_r($result);
    
} catch (Exception $e) {
    die($e->getMessage());
}





