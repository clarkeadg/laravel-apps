<div>
    <!-- Title / Close-->
    <div class="flex items-center justify-between">
        <h5 class="mr-3 font-bold text-lg text-black max-w-none">Delete list</h5>               
        
        <button type="button" class="z-50 cursor-pointer" wire:click="$dispatch('closeModal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- content -->
    <div class="mt-5 py-2">
        <p class="mb-4">
            Are you sure you want to delete this item?
        </p>
        <div class="flex w-full justify-between">
            <button wire:click="$dispatch('closeModal')" class="inline-flex px-4 py-2 rounded-full text-gray-500 bg-white border border-gray-500 hover:text-white hover:bg-black hover:border-white">
                Cancel
            </button>
            <button wire:click="handleDelete()" class="inline-flex px-4 py-2 rounded-full text-white bg-red-500 hover:bg-red-400">
                <x-heroicon-o-arrow-path wire:loading class="h-6 w-6 mr-2 text-white animate-spin"/>
                <span>Delete</span>
            </button>
        </div>
    </div>
</div>