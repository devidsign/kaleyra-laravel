<?php
namespace Idsign\Kaleyra\Http\Controllers;

use Idsign\Kaleyra\Kaleyra;

class UserController
{
    private $bandyer;

    public function __construct() {
        $this->bandyer = new Kaleyra();
    }

    public function index()
    {
        $response = $this->bandyer->listUsers();
        return $this->respond();
    }
    public function show($id)
    {
        $response = $this->bandyer->getUser($id);
        return $this->respond();
    }
    public function userRooms($id)
    {
        $response = $this->bandyer->getUserRooms($id,request()->all());
        return $this->respond();
    }
    public function store()
    {
        $response = $this->bandyer->createUser(request()->all());
        return $this->respond();
    }
    public function update($id)
    {
        $response = $this->bandyer->updateUser($id,request()->all());
        return $this->respond();
    }
    public function updatePermissions()
    {
        $response = $this->bandyer->updatePermissions(request()->all());
        return $this->respond();
    }
    public function updateAvatar($id)
    {
        $response = $this->bandyer->updateAvatar($id,request()->file("avatar"));
        return $this->respond();
    }
    private function respond(){
        return response()->json($this->bandyer->getContents(), $this->bandyer->getStatus());
    }
}
