<x-idsign::modal
    id="registration-modal-{{\Str::uuid()->toString()}}"
    event="bandyer-registration-modal-toggle"
    mainTag="div"
    title="Registrazioni"
    :hasActions="false"
    wire:key="registration-modal-key{{\Str::uuid()->toString()}}"
>
    @forelse($registrations as $registration)
        <livewire:bandyer-registration-download
            :session="$registration"
            wire:key="session-{{ $registration['id']  }}"
        />
    @empty
        <div class="w-full flex justify-center">
            {{ __('Nessuna registrazione disponibile') }}
        </div>
    @endforelse
</x-idsign::modal>
