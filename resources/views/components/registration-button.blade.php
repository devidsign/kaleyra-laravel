@props([
    'room'
])
<x-idsign::badge color="positive" class="cursor-pointer flex space-x-2" wire:click.prevent="$dispatchTo('bandyer-registration-modal', 'bandyer-open-registration-modal', { room: {{ $room }} })">
    <x-idsign-tabler class="h-6 w-6" icon="video"></x-idsign-tabler>
    <span>Vedi Registrazione</span>
</x-idsign::badge>
