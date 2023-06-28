<?php

namespace SdnSdk;

/**
 * Cache constants used when instantiating SDN Client to specify level of caching
 * @package SdnSdk
 */
class Cache {
    const NONE = -1;
    const SOME = 0;
    const ALL = 1;

    public static array $levels = [
        self::NONE,
        self::SOME,
        self::ALL,
    ];
}
