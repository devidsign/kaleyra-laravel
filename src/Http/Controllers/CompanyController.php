<?php
namespace Idsign\Kaleyra\Http\Controllers;

use Idsign\Kaleyra\Kaleyra;

class CompanyController
{
    private $bandyer;

    public function __construct() {
        $this->bandyer = new Kaleyra();
    }
    public function index()
    {
        $response = $this->bandyer->getCompany();
        return $this->respond();
    }
    public function update()
    {
        $response = $this->bandyer->updateCompany(request()->all());
        return $this->respond();
    }
    public function logoUpdate()
    {
        $response = $this->bandyer->logoUpdate(request()->file("logo"));
        return $this->respond();
    }
    public function backgroundUpdate()
    {
        $response = $this->bandyer->backgroundUpdate(request()->file("virtual_background"));
        return $this->respond();
    }

    private function respond(){
        return response()->json($this->bandyer->getContents(), $this->bandyer->getStatus());
    }
}
