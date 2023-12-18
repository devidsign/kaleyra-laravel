<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait User
{
    public function listUsers()
    {
        return $this->query('users');
    }

    public function createUser($data)
    {
        return $this->json('users', "POST", $data);
    }

    public function getUser($id)
    {
        return $this->query('users/'.$id);
    }

    public function updateUser($id,$data)
    {
        return $this->json('users/'.$id, "PUT",$data);
    }

    public function deleteUser($id)
    {
        return $this->json('users/'.$id, "DELETE");
    }

    public function updateAvatar($id, UploadedFile $file)
    {
        return $this->multipart('users/'.$id.'/avatar', $file, "avatar", "PUT");
    }

    public function deleteAvatar($id, UploadedFile $file)
    {
        return $this->multipart('user/avatar/update/'.$id, $file,"avatar","PUT");
    }

    /*public function updatePermissions($data)
    {
        return $this->json('user/update/all/permissions',"PUT",$data);
    }

    public function getUserRooms($id,$data)
    {
        return $this->json('user/room/list/'.$id, "GET", $data);
    }*/
}
