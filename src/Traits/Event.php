<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait Event
{
    public function configure($data, $headers, $version = ''){
        return $this->json($version. 'hook/configure', "POST", $data, $headers);
    }

    public function getHooks () {
        return $this->query('webhooks');
    }

    public function getHook ($hookId) {
        return $this->query('webhooks/'.$hookId);
    }

    public function createHook ($data) {
        return $this->json('webhooks', 'POST', $data);
    }

    public function updateHook ($hookId, $data) {
        return $this->json('webhooks/'.$hookId, 'PUT', $data);
    }

    public function deleteHook ($hookId) {
        return $this->json('webhooks/'.$hookId, 'DELETE');
    }
}
