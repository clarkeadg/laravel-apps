<div>
    <!-- Title / Close-->
    <div class="flex items-center justify-between">
        <h5 class="mr-3 font-bold text-lg text-black max-w-none">Report</h5>               
        
        <button type="button" class="z-50 cursor-pointer" wire:click="$dispatch('closeModal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- content -->
    <div class="mt-5 py-2">
        @livewire('moderation.report-create', [
            'app' => $app,
            'profile_id' => $id,
            'object_type' => $object_type,
            'object_id' => $object_id
        ])         
    </div>
</div>
