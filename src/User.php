<?php

namespace SdnSdk;

/**
 * The User class can be used to call user specific functions.
 *
 * @package SdnSdk
 */
class User {

    protected string $userId;
    protected ?string $displayName;
    protected HttpApi $api;

    /**
     * User constructor.
     *
     * @param HttpApi $api
     * @param string $userId
     * @param string|null $displayName
     * @throws Exceptions\ValidationException
     */
    public function __construct(HttpApi $api, string $userId, ?string $displayName = null) {
        Util::checkUserId($userId);
        $this->userId = $userId;
        $this->displayName = $displayName;
        $this->api = $api;
    }

    /**
     * Get this user's display name.
     *
     * @param Room|null $room Optional. When specified, return the display name of the user in this room.
     * @return string The display name. Defaults to the user ID if not set.
     * @throws Exceptions\SDNException
     * @throws Exceptions\SDNHttpLibException
     * @throws Exceptions\SDNRequestException
     */
    public function getDisplayName(?Room $room = null): string {
        if ($room) {
            return array_get($room->getMembersDisplayNames(), $this->userId, $this->userId);
        }

        if (!$this->displayName) {
            $this->displayName = $this->api->getDisplayName($this->userId);
        }

        return $this->displayName ?: $this->userId;
    }

    /**
     * Set this users display name.
     *
     * @param string $displayName Display Name
     * @return array|string
     * @throws Exceptions\SDNException
     * @throws Exceptions\SDNHttpLibException
     * @throws Exceptions\SDNRequestException
     */
    public function setDisplayName(string $displayName) {
        $this->displayName = $displayName;

        return $this->api->setDisplayName($this->userId, $displayName);
    }

    /**
     * @return string|null
     * @throws Exceptions\SDNException
     * @throws Exceptions\SDNHttpLibException
     * @throws Exceptions\SDNRequestException
     * @throws Exceptions\ValidationException
     */
    public function getAvatarUrl(): ?string {
        $mxUrl = $this->api->getAvatarUrl($this->userId);
        $url = null;
        if ($mxUrl) {
            $url = $this->api->getDownloadUrl($mxUrl);
        }

        return $url;
    }

    /**
     * Set this users' avatar.
     *
     * @param string $avatarUrl mxc url from previously uploaded
     * @return array|string
     * @throws Exceptions\SDNException
     * @throws Exceptions\SDNHttpLibException
     * @throws Exceptions\SDNRequestException
     */
    public function setAvatarUrl(string $avatarUrl) {
        return $this->api->setAvatarUrl($this->userId, $avatarUrl);
    }

    public function userId(): string {
        return $this->userId;
    }

}
