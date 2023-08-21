#  sendingnetwork-php-sdk
[![Software License][ico-license]](LICENSE.md)
[![Software Version][ico-version]](https://packagist.org/packages/sending-network/sdn-php-sdk)
![Software License][ico-downloads]

A PHP SDK for Sending-Network.

## Installation

```
composer require sending-network/sdn-php-sdk
```

## Usage
### Prepare a configuration file
Provide server node url, wallet address, private key and developer key in file bot.creds.json:
```json
{
    "nodeUrl": "https://example.com",
    "walletAddress": "<WALLET_ADDRESS>",
    "privateKey": "<PRIVATE_KEY>",
    "developerKey": "<DEVELOPER_KEY>"
}
```

### Create an instance of `SDNClient`
```php
require('vendor/autoload.php');
use SdnSdk\SDNClient;

$json_data = file_get_contents("bot.creds.json");
$config = json_decode($json_data,true);
$client = new SDNClient($config['nodeUrl']);

// login
$token = $client->login($config['walletAddress'], $config['privateKey'], $config['developerKey']);

// add listener for events
$client->addListener(function ($event) {
    // process room event here
    print_r($event);
}, "m.room.message");

// start listen
$client->listenForever();
```

### Call API functions
```php
// create new room
$client->createRoom("room name");

// invite user
$client->getRoom($roomId)->inviteUser($userId);

// send message
$client->getRoom($roomId)->sendText("hello");
```

## Examples
See more use cases in `examples` directory.

## License
[MIT License](LICENSE.md).

[ico-version]: https://img.shields.io/packagist/v/sending-network/sdn-php-sdk.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sending-network/sdn-php-sdk.svg?style=flat-square
