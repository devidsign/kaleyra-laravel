<?php

namespace Idsign\Kaleyra\Http\Livewire;

use Idsign\Kaleyra\Http\Controllers\RoomController;
use Illuminate\Support\Arr;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class RegistrationDownload extends Component
{
    use Toastable;

    public array $session;
    public string|null $link = null;

    public function mount(array $session): void
    {
        $this->session = $session;
    }
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('bandyer::livewire.registration-download');
    }


    public function download(): void
    {
        $response = app(RoomController::class)->getRecording($this->session['id']);
        $session = json_decode($response->content() ?: '', true);
        $status = Arr::get($session, 'status', 200);
        $code = Arr::get($session, 'code', 'generic');
        $errorMessage = '';
        $this->link = Arr::get($session, 'url', null);

        if($status == 400 || $status == 412) {
            switch($code) {
                case 'recording_expired':
                    $errorMessage = __('Registrazione non più disponibile');
                    break;
                default:
                    $errorMessage = __('Si è verificato un errore. Ti preghiamo di riprovare');
                    break;
            }
            $this->error($errorMessage);
        }
    }
}
