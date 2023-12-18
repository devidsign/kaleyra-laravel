<?php

namespace Idsign\Kaleyra\Traits;

trait Session
{

    public function allSessions($data)
    {
        return $this->query('sessions', $data);
    }

    public function getRoomSessions($roomId, $data = []): bool
    {
        $data['room_id'] = $roomId;
        return $this->allSessions($data);
    }

    public function getSession($id)
    {
        return $this->query('sessions/' . $id);
    }

    public function getSessionRecording($id): bool
    {
        return $this->query('sessions/' . $id . '/recording');
    }

    public function deleteSessionRecording($id)
    {
        return $this->json('sessions/' . $id . '/recording', "DELETE");
    }
}
