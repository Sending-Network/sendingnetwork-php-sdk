<?php

namespace SdnSdk\Exceptions;

/**
 * The server gave an unexpected response.
 *
 * @package SdnSdk\Exceptions
 */
class SDNUnexpectedResponse extends SDNException {

    protected $content;

    function __construct(string $content = '') {
        parent::__construct($content);
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }
}
