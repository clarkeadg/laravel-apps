@auth
    <button type="button" onclick="Livewire.dispatch('openModal', { component: 'modals.modal-tweet-compose', arguments: { app: '{{ $app }}', view: '.modals._tweet-compose' }})" class="py-2 flex grow w-full justify-center items-center rounded-full bg-blue-500 hover:bg-blue-700 text-white font-bold">
        <x-heroicon-o-pencil-square class="h-6 w-6"/>
        <span class="ml-2">{{ __('Compose') }}</span> 
    </button>
@endauth 