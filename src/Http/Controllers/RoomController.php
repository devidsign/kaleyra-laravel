<?php
namespace Idsign\Kaleyra\Http\Controllers;

use Idsign\Kaleyra\Kaleyra;

class RoomController
{
    private $bandyer;

    public function __construct() {
        $this->bandyer = new Kaleyra();
    }
    public function index()
    {
        $response = $this->bandyer->listRooms();
        return $this->respond();
    }
    public function show($id)
    {
        $response = $this->bandyer->getRoom($id);
        return $this->respond();
    }

    public function getRecording($sessionId)
    {
        $response = $this->bandyer->getRecording($sessionId);
        return $this->respond();
    }

    public function envelopes($id)
    {
        $response = $this->bandyer->getEnvelopes($id);
        return $this->respond();
    }
    public function uploads($id)
    {
        $response = $this->bandyer->getUploads($id);
        return $this->respond();
    }
    public function disable($id)
    {
        $response = $this->bandyer->disableRoom($id);
        return $this->respond();
    }
    public function store()
    {
        $response = $this->bandyer->createRoom(request()->all());
        return $this->respond();
    }

    private function respond(){
        return response()->json($this->bandyer->getContents(), $this->bandyer->getStatus());
    }
}
