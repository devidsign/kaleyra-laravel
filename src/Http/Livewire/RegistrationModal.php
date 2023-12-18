<?php

namespace Idsign\Kaleyra\Http\Livewire;

use Idsign\Kaleyra\Kaleyra;
use Idsign\Kaleyra\Http\Controllers\RoomController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrationModal extends Component
{
    public array $registrations = [];

    public function render()
    {
        return view('bandyer::livewire.registration-modal');
    }

    #[On('bandyer-open-registration-modal')]
    public function open($room): void
    {
        $bandyer = new Kaleyra();
        if ($bandyer->getRoomSessions($room)) {
            $roomInfo = json_decode(json_encode($bandyer->getContents()), true);
            $this->registrations = collect(Arr::get($roomInfo, 'sessions', []))->values()->all();
        }
        $this->dispatch('bandyer-registration-modal-toggle');
    }
}
