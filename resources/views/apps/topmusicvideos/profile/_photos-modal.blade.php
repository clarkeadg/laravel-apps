<div id="photosModal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!--
        Background backdrop, show/hide based on modal state.

        Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
        Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div id="closePhotosModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>        

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto pointer-events-none">
        <div class="flex min-h-full items-center justify-center text-center">
            
            <!-- Close Modal Button -->
            <a id="closePhotosModal" href="#" class="absolute top-10 right-10 pointer-events-auto">
                <x-heroicon-o-x-circle class="h-12 w-12 text-white"/>
            </a>

            <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden text-left shadow-xl transition-all w-full max-w-xl pointer-events-auto">
                <!-- Modal Content -->
                <div class="photos-slider-big">
                    @foreach ($profile->photos as $photo)
                        <!-- Card -->
                        <div class="photos-slider-card">
                            <!-- Image -->
                            <div class="img-container overflow-hidden border border-gray-200 rounded-lg">
                                <img class="w-full" src="{{ $photo->getUrl() }}" alt="" />  
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>