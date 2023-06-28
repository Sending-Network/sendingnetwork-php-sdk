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
Provide server node url, wallet address and private key in file bot.creds.json:
```json
{
    "nodeUrl": "https://example.com",
    "walletAddress": "",
    "privateKey": ""
}
```

### Create an instance of `SDNClient`
```php
require('vendor/autoload.php');
use SdnSdk\SDNClient;

$client = new SDNClient("https://example.com");

// login
$token = $client->login($walletAddress, $privateKey);

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
