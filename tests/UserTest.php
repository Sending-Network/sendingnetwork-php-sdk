<?php

namespace SdnSdk\Tests;

use ReflectionException;
use SdnSdk\Exceptions\SDNException;
use SdnSdk\Exceptions\SDNHttpLibException;
use SdnSdk\Exceptions\SDNRequestException;
use SdnSdk\Exceptions\ValidationException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use SdnSdk\Room;
use SdnSdk\SDNClient;
use SdnSdk\User;

class UserTest extends BaseTestCase {
    const HOSTNAME = "http://localhost";
    protected string $userId = "@test:localhost";
    protected string $roomId = '!test:localhost';
    /**
     * @var SDNClient
     */
    protected SDNClient $client;
    /**
     * @var User
     */
    protected User $user;
    /**
     * @var Room
     */
    protected Room $room;

    /**
     * @throws ReflectionException|ValidationException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new SDNClient(self::HOSTNAME);
        $this->user = new User($this->client->api(), $this->userId);
        $this->room = $this->invokePrivateMethod($this->client, 'mkRoom', [$this->roomId]);
    }

    /**
     * @throws SDNHttpLibException
     * @throws SDNException
     * @throws SDNRequestException
     */
    public function testDisplayName() {
        // No displayname
        $displayname = 'test';
        $this->assertEquals($this->user->userId(), $this->user->getDisplayName($this->room));
        $container = [];
        $handler = $this->getMockClientHandler([new Response(200, [], '{}')], $container);
        $this->client->api()->setClient(new Client(['handler' => $handler]));
        $this->assertEquals($this->user->userId(), $this->user->getDisplayName());
        $this->assertCount(1, $container);
    }

    /**
     * @throws SDNHttpLibException
     * @throws SDNException
     * @throws SDNRequestException
     */
    public function testDisplayNameGlobal() {
        $displayname = 'test';

        // Get global displayname
        $container = [];
        $str = sprintf('{"displayname": "%s"}', $displayname);
        $handler = $this->getMockClientHandler([new Response(200, [], $str)], $container);
        $this->client->api()->setClient(new Client(['handler' => $handler]));
        $this->assertEquals($displayname, $this->user->getDisplayName());
        $this->assertCount(1, $container);

    }
}
