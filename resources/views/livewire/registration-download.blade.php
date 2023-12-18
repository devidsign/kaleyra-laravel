<div class="flex flex-col min-h-[60px]">
    <div class="flex justify-between items-center ">
        <div class="text-primary-500 dark:text-white flex flex-col" >
            <div class="font-bold">{{ $session['id'] ?? '' }}</div>
            <div class="text-xs flex space-x-2">
                <span>{{ \Carbon\Carbon::parse($session['creation_date'])->format('d/m/Y H:i:s') ?? '' }}</span>
                <span>|</span>
                <span>
                    {{ gmdate("H\h i\m s\s", $session['duration']) }}
                </span>
            </div>
        </div>
        <div>
            @if($link)
                <x-idsign::button as="a" color="primary" href="{{ $link }}" target="_blank" class="block w-[150px]">
                    <div x-data="{timer: 30}"
                         x-init="() => {
                            let counter = setInterval(function() {
                                timer--;
                                if(timer == 1) {
                                    clearInterval(counter);
                                    $wire.$set('link', null)
                                };
                            }, 1000);
                         }"
                         class="flex space-x-2"
                    >
                        <span>SCARICA</span>
                        <span class="inline-block text-right">( <span x-text="timer" ></span> )</span>
                    </div>
                </x-idsign::button>
            @else
                <x-idsign::button type="button" color="primary" wire:click="download" wire:target="download"  class="block w-[150px]">RICHIEDI</x-idsign::button>
            @endif
        </div>
    </div>
</div>
