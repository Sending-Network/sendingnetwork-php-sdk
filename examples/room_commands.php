<?php
namespace SdnSdk\Examples;

require __DIR__ . '/../vendor/autoload.php';

use Exception;
use SdnSdk\SDNClient;

$commands = <<<'EOD'
Available commands:
room list -- List rooms
room create <name> -- Create new room
room invite <roomId> <userId> -- Invite user to room
room join <roomId> -- Join room by id
room kick <roomId> <userId> -- Kick user by userId
room leave <roomId> -- Leave room by id
room members <roomId> -- List room members
room send <roomId> <message text> -- Send a text message
EOD;

$json_data = file_get_contents('bot.creds.json');
$config = json_decode($json_data,true);

if (!isset($config['accessToken']) || $config['accessToken'] == "") {
    print("accessToken not found\n");
    exit(1);
}

try {
    $client = new SDNClient($config['nodeUrl'], $config['accessToken']);

    print($commands . "\n");

    while (true) {
        $cmdRaw = readline('[input command]: ');
        if ($cmdRaw == "q" || $cmdRaw == "quit") {
            break;
        }
        $cmdParams = explode(' ', $cmdRaw);
        if (count($cmdParams) < 2) {
            continue;
        }
        $action = $cmdParams[1];
        switch ($action) {
            case "list":
                $rooms = $client->getJoinedRooms();
                print_r($rooms["joined_rooms"]);
                break;
            case "create":
                $roomName = $cmdParams[2];
                $room = $client->createRoom($roomName, true);
                printf($room->getId());
                break;
            case "join":
                $roomId = $cmdParams[2];
                $client->joinRoom($roomId);
                printf("join success\n");
                break;
            case "leave":
                $roomId = $cmdParams[2];
                $success = $client->getRoom($roomId)->leave();
                printf("leave success: %s\n", var_export($success, true));
                break;
            case "invite":
                $roomId = $cmdParams[2];
                $userId = $cmdParams[3];
                $success = $client->getRoom($roomId)->inviteUser($userId);
                printf("invite success: %s\n", var_export($success, true));
                break;
            case "kick":
                $roomId = $cmdParams[2];
                $userId = $cmdParams[3];
                $success = $client->getRoom($roomId)->kickUser($userId);
                printf("kick success: %s\n", var_export($success, true));
                break;
            case "members":
                $roomId = $cmdParams[2];
                $joinedMembers = $client->getRoom($roomId)->getJoinedMembers();
                print_r($joinedMembers);
                break;
            case "send":
                $roomId = $cmdParams[2];
                $message = $cmdParams[3];
                $resp = $client->getRoom($roomId)->sendText($message);
                print_r($resp);
                break;
            default:
                break;
        }

    }
} catch (Exception $e) {
    print($e->getMessage());
}