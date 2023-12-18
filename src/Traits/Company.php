<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait Company
{
    public function getCompany()
    {
        return $this->query('company');
    }

    public function updateCompany($data)
    {
        return $this->json('company', "PUT", $data);
    }

    public function getCompanyTheme()
    {
        return $this->query('company/theme');
    }

    public function updateCompanyTheme($data)
    {
        return $this->json('company/theme', "PUT", $data);
    }

    public function updateCompanyThemeLogo(UploadedFile $file)
    {
        return $this->multipart('company/theme/logo', $file, "logo", "PUT");
    }

    public function getCompanyVirtualBackgrounds()
    {
        return $this->query('company/virtual-backgrounds');
    }

    public function createCompanyVirtualBackground(UploadedFile $file)
    {
        return $this->multipart('company/virtual-background', $file, 'virtual_background');
    }

    public function deleteCompanyVirtualBackground($data)
    {
        return $this->json('company/virtual-background', "DELETE", $data);
    }

    public function getCompanyTranslations()
    {
        return $this->query('company/translations');
    }

    public function updateCompanyTranslations(UploadedFile $file, $language = 'en')
    {
        return $this->multipart('company/translations/' . $language, $file, 'translation', "PUT");
    }

    public function deleteCompanyTranslations($language = 'it')
    {
        return $this->json('company/translations/' . $language, "DELETE");
    }

    public function getCompanyRecordingSettings()
    {
        return $this->query('company/recording-settings');
    }

    public function updateCompanyRecordingSettings($data)
    {
        return $this->json('company/recording-settings', "PUT", $data);
    }

    public function getCompanyEncryptionKeys($params = [])
    {
        return $this->query('company/encryption-keys', $params);
    }

    public function getCompanyEncryptionKeysById($id)
    {
        return $this->query('company/encryption-keys/' . $id);
    }

    public function createCompanyEncryptionKey($data)
    {
        return $this->json('company/encryption-keys', "POST", $data);
    }
}
