<?php

namespace Idsign\Kaleyra\Traits;

trait Room
{
    public function listRooms(): bool
    {
        return $this->query('rooms');
    }

    public function getRoom($roomId): bool
    {
        return $this->query('rooms/'.$roomId);
    }

    public function createRoom($data): bool
    {
        return $this->json('rooms', "POST", $data);
    }

    public function deleteRoom($roomId): bool
    {
        return $this->json('rooms/'.$roomId, "DELETE");
    }

    public function disableRoom($roomId): bool
    {
        return $this->json('rooms/'.$roomId.'/disable', "PUT");
    }

    public function startRecording($roomId): bool
    {
        return $this->json('rooms/'.$roomId.'/start-recording', "POST");
    }

    public function stopRecording($roomId): bool
    {
        return $this->json('rooms/'.$roomId.'/stop-recording', "POST");
    }

    public function callRoom($roomId, $data): bool
    {
        return $this->json('rooms/'.$roomId.'/call', "POST", $data);
    }

    public function getRoomPartecipants($roomId, $isAdmin = false): bool
    {
        return $this->query('rooms/'.$roomId.'/partecipants', ['is_admin' => $isAdmin]);
    }

    public function addRoomPartecipants($roomId, $data): bool
    {
        return $this->json('rooms/'.$roomId.'/partecipants', "POST", $data);
    }

    public function getRoomPartecipant($roomId, $userId): bool
    {
        return $this->query('rooms/'.$roomId.'/participants/'.$userId);
    }

    public function updateRoomPartecipant($roomId, $userId, $data): bool
    {
        return $this->json('rooms/'.$roomId.'/participants/'.$userId, "PUT", $data);
    }

    public function deleteRoomPartecipant($roomId, $userId, $data): bool
    {
        return $this->json('rooms/'.$roomId.'/participants/'.$userId, "DELETE", $data);
    }

    public function getRoomUploads($roomId): bool
    {
        return $this->query('uploads', ['room_id' => $roomId]);
    }

}
