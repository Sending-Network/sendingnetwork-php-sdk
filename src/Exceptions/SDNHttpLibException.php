<?php

namespace SdnSdk\Exceptions;

use Exception;

/**
 * The library used for http requests raised an exception.
 *
 * @package SdnSdk\Exceptions
 */
class SDNHttpLibException extends SDNException {

    public function __construct(Exception $originalException, string $method, string $endpoint) {
        $msg = sprintf(
            'Something went wrong in %s requesting %s: %s',
            $method,
            $endpoint,
            $originalException->getMessage(),
        );
        parent::__construct($msg, $originalException->getCode(), $originalException);
    }
}
