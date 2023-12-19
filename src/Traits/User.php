<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait User
{
    public function allUsers()
    {
        return $this->query('users');
    }

    public function createUser($data)
    {
        if (!isset($data['role']) || !$data['role']) {
            $data['role'] = config('bandyer.default_role', 'basic');
        }
        return $this->json('users', "POST", $data);
    }

    public function createBasicUser($data = [])
    {
        $data['role'] = 'basic';
        return $this->createUser($data);
    }
    public function createPlusUser($data = [])
    {
        $data['role'] = 'plus';
        return $this->createUser($data);
    }

    public function getUser($id)
    {
        return $this->query('users/' . $id);
    }

    public function updateUser($id, $data)
    {
        return $this->json('users/' . $id, "PUT", $data);
    }

    public function deleteUser($id)
    {
        return $this->json('users/' . $id, "DELETE");
    }

    public function updateAvatar($id, UploadedFile $file)
    {
        return $this->multipart('users/' . $id . '/avatar', $file, "avatar", "PUT");
    }

    public function deleteAvatar($id)
    {
        return $this->json('users/' . $id. '/avatar', "DELETE");
    }

}
