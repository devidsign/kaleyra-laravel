<?php

namespace Idsign\Kaleyra\Helpers;

use Idsign\Kaleyra\Kaleyra;
use Illuminate\Support\Arr;

class RoomHelper
{

    private static function getRoomConfig($config): array
    {
        return array_merge(
            config('kaleyra.room.config', []),
            [
                'recording' => Arr::get($config, 'recording', 'none'),
                'duration' => Arr::get($config, 'duration', ''),
                'call_type' => Arr::get($config, 'call_type', 'audio_video'),
                'live' => Arr::get($config, 'live', true),
                'description' => Arr::get($config, 'description', ''),
            ]
        );
    }

    public static function addRoomByOperator(
        $operator, $operatorTools = [], $extraUsers = 0, $users = [], $usersTools = [], $config = []
    ) {

        $kaleyra = new Kaleyra();
        $participants = [];
        $tools = config('kaleyra.user.tools', []);
        $participants[] = [
            'user_id' => $operator,
            'is_admin' => true,
            'tools' => array_merge($tools, $operatorTools)
        ];
        if ($extraUsers > 0) {
            while ($extraUsers > 0) {
                if ($kaleyra->createBasicUser()) {
                    $response = $kaleyra->getContents();
                    $users[] = $response->id;
                    $extraUsers--;
                }
            }
        }
        foreach ($users as $user) {
            if (is_string($user)) {
                $user = [
                    'user_id' => $user
                ];
            }
            $user['is_admin'] = false;
            $user['tools'] = array_merge($tools, $usersTools, $user['tools'] ?? []);
            $participants[] = $user;
        }

        $data = array_merge(
            self::getRoomConfig($config),
            [
                'participants' => $participants
            ]
        );

        if (!$kaleyra->createRoom($data)) {
            return false;
        }

        $response = $kaleyra->getContents();

        return $response->id;
    }
}