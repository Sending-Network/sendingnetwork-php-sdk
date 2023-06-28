<?php

namespace SdnSdk\Exceptions;

use JsonException;
use function json_decode;

/**
 * The server returned an error response.
 *
 * @package SdnSdk\Exceptions
 */
class SDNRequestException extends SDNException {

    protected string $content;
    public ?string $errCode;

    public function __construct(int $code = 0, string $content = "") {
        parent::__construct($content, $code);
        $this->code = $code;
        $this->content = $content;
        try {
            $decoded = json_decode($content, TRUE, 512, JSON_THROW_ON_ERROR);
            $this->errCode = $decoded['errcode'] ?? NULL;
        }
        catch (JsonException $ex) {
            $this->errCode = NULL;
        }
    }

    /**
     * @return int
     */
    public function getHttpCode(): int {
        return $this->getCode();
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }
}
