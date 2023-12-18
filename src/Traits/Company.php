<?php

namespace Idsign\Kaleyra\Traits;

use Illuminate\Http\UploadedFile;

trait Company
{
    public function getCompany(){
        return $this->query('company');
    }
    public function updateCompany($data){
        return $this->json('company', "PUT", $data);
    }
    public function getCompanyTheme(){
        return $this->query('company/theme');
    }
    public function updateCompanyTheme($data){
        return $this->json('company/theme', "PUT", $data);
    }
    public function updateCompanyThemeLogo(UploadedFile $file){
        return $this->multipart('company/theme/logo', $file,  "logo", "PUT");
    }
    public function getCompanyVirtualBackgrounds () {
        return $this->query('company/virtual-backgrounds');
    }
    public function createCompanyVirtualBackground (UploadedFile $file) {
        return $this->multipart('company/virtual-background',$file, 'virtual_background', "POST");
    }
    public function deleteCompanyVirtualBackground ($data) {
        return $this->json('company/virtual-background', "DELETE", $data);
    }
    public function getCompanyTranslations () {
        return $this->query('company/translations');
    }
    public function updateCompanyTranslations (UploadedFile $file, $iso = 'it') {
        return $this->multipart('company/translations/'.$iso, $file, 'translation', "PUT");
    }
    public function deleteCompanyTranslations ($iso = 'it') {
        return $this->json('company/translations/'.$iso, "DELETE");
    }
    public function getCompanyRecordingSettings () {
        return $this->query('company/recording-settings');
    }
    public function updateCompanyRecordingSettings ($data) {
        return $this->json('company/recording-settings', "PUT", $data);
    }
    public function getCompanyEncritpionKeys ($params = []) {
        return $this->query('company/encryption-keys', $params);
    }
    public function getCompanyEncritpionKeysById ($keyId) {
        return $this->query('company/encryption-keys/'.$keyId);
    }
    public function createCompanyEncritpionKey ($data) {
        return $this->json('company/encryption-keys', "POST", $data);
    }
}
