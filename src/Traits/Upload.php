<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait Upload
{
    public function allUploads($data = [])
    {
        return $this->query('uploads', $data);
    }

    public function getUpload($key)
    {
        return $this->query('uploads/' . $key);
    }
    public function deleteUpload($key)
    {
        return $this->json('uploads/' . $key, "DELETE");
    }


}
