<?php

namespace SdnSdk;

use Elliptic\EC;
use Exception;
use kornrunner\Keccak;
use SdnSdk\Exceptions\ValidationException;

class Util {

    /**
     * Check if provided roomId is valid
     *
     * @param string $roomId
     * @throws ValidationException
     */
    public static function checkRoomId(string $roomId) {
        if (strpos($roomId, '!') !== 0) {
            throw new ValidationException("RoomIDs start with !");
        }

        if (strpos($roomId, ':') === false) {
            throw new ValidationException("RoomIDs must have a domain component, seperated by a :");
        }
    }

    /**
     * Check if provided userId is valid
     *
     * @param string $userId
     * @throws ValidationException
     */
    public static function checkUserId(string $userId) {
        if (strpos($userId, '@') !== 0) {
            throw new ValidationException("UserIDs start with @");
        }

        if (strpos($userId, ':') === false) {
            throw new ValidationException("UserIDs must have a domain component, seperated by a :");
        }
    }

    /**
     * @throws ValidationException
     */
    public static function checkMxcUrl(string $mxcUrl) {
        if (substr($mxcUrl, 0, 6) != 'mxc://') {
            throw new ValidationException('MXC URL did not begin with \'mxc://\'');
        }
    }

    /**
     * @throws Exception
     */
    public static function signMessage($message, $privateKey) {
        $ec = new EC('secp256k1');
        $ecPrivateKey = $ec->keyFromPrivate($privateKey, 'hex');
        $message = "\x19Ethereum Signed Message:\n" . strlen($message) . $message;
        $hash = Keccak::hash($message, 256);
        $signature = $ecPrivateKey->sign($hash, ['canonical' => true]);

        $r = str_pad($signature->r->toString(16), 64, '0', STR_PAD_LEFT);
        $s = str_pad($signature->s->toString(16), 64, '0', STR_PAD_LEFT);
        $v = dechex($signature->recoveryParam + 27);

        return "0x$r$s$v";
    }
}
