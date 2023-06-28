<?php

namespace SdnSdk\Crypto;

use SdnSdk\HttpApi;

/**
 * OlmDevice stub for typehinting
 *
 * @package SdnSdk\Crypto
 */
class OlmDevice {

    public function __construct(HttpApi $client, string $userId, ?string $deviceId, array &$encryptionConf) {
    }

    public function uploadIdentityKeys() {
    }

    public function uploadOneTimeKeys() {
    }

    public function updateOneTimeKeysCounts($device_one_time_keys_count) {

    }

}
