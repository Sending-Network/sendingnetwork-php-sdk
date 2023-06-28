<?php

namespace SdnSdk\Examples;

require __DIR__ . '/../vendor/autoload.php';

use Exception;
use kornrunner\Keccak;
use Elliptic\EC;
use SdnSdk\SDNClient;

const CONFIG_FILE = "bot.creds.json";
$json_data = file_get_contents(CONFIG_FILE);
$config = json_decode($json_data,true);
print_r($config);

try {
    $client = new SDNClient($config['nodeUrl']);
    $accessToken = $client->login($config['walletAddress'], $config['privateKey']);

    // save accessToken
    $config["accessToken"] = $accessToken;
    file_put_contents(CONFIG_FILE, json_encode($config, JSON_PRETTY_PRINT));

    // listen for room events
    $client->addListener(function ($event) {
        // process room event here
        print_r($event);
    }, "m.room.message");

    // start listen
    $client->listenForever();

} catch (Exception $e) {
    print($e->getMessage());
}
