<?php

namespace Idsign\Kaleyra\Traits;

trait Room
{
    public function allRooms(): bool
    {
        return $this->query('rooms');
    }

    public function createRoom($data): bool
    {
        return $this->json('rooms', "POST", $data);
    }

    public function getRoom($id): bool
    {
        return $this->query('rooms/' . $id);
    }

    public function deleteRoom($id): bool
    {
        return $this->json('rooms/' . $id, "DELETE");
    }

    public function disableRoom($id, $data = []): bool
    {
        return $this->json('rooms/' . $id . '/disable', "PUT", $data);
    }

    public function startRecording($id): bool
    {
        return $this->json('rooms/' . $id . '/start-recording');
    }

    public function stopRecording($id): bool
    {
        return $this->json('rooms/' . $id . '/stop-recording');
    }

    public function callRoom($id, $data): bool
    {
        return $this->json('rooms/' . $id . '/call', "POST", $data);
    }

    public function getRoomParticipants($id, $isAdmin = false): bool
    {
        return $this->query('rooms/' . $id . '/partecipants', ['is_admin' => $isAdmin]);
    }

    public function addRoomParticipant($id, $data): bool
    {
        return $this->json('rooms/' . $id . '/partecipants', "POST", $data);
    }

    public function getRoomParticipant($id, $userId): bool
    {
        return $this->query('rooms/' . $id . '/participants/' . $userId);
    }

    public function updateRoomParticipant($id, $userId, $data): bool
    {
        return $this->json('rooms/' . $id . '/participants/' . $userId, "PUT", $data);
    }

    public function deleteRoomParticipant($id, $userId): bool
    {
        return $this->json('rooms/' . $id . '/participants/' . $userId, "DELETE");
    }

}
