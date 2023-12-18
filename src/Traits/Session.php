<?php

namespace Idsign\Kaleyra\Traits;

trait Session
{
    public function getRoomSessions($roomId): bool
    {
        return $this->query('sessions', [
            'room_id' => $roomId
        ]);
    }

    public function getRecording($sessionId): bool
    {
        return $this->query('sessions/'.$sessionId.'/recording');
    }
}
