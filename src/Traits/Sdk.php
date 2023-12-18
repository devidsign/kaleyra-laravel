<?php

namespace Idsign\Kaleyra\Traits;

trait Sdk
{
    public function createToken($userId): bool
    {
        return $this->json('sdk/credentials', "POST", [
            'user_id' => $userId
        ]);
    }
}
