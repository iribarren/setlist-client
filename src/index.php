<?php

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$client = new SetlistClient\Client("https://api.setlist.fm/rest/0.1/");

$result = $client->artist->searchByName("Metallica");

print_r($result);

