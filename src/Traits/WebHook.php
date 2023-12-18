<?php

namespace Idsign\Kaleyra\Traits;

trait WebHook
{
    public function allWebHooks()
    {
        return $this->query('webhooks');
    }

    public function getWebHook($id)
    {
        return $this->query('webhooks/' . $id);
    }

    public function createWebHook($data)
    {
        return $this->json('webhooks', 'POST', $data);
    }

    public function updateWebHook($id, $data)
    {
        return $this->json('webhooks/' . $id, 'PUT', $data);
    }

    public function deleteWebHook($id)
    {
        return $this->json('webhooks/' . $id, 'DELETE');
    }
}
