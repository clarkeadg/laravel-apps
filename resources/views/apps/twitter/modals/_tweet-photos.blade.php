<div class="w-full">
    <!-- Title / Close-->
    <div class="flex items-center justify-end">    
        <button type="button" class="z-50 cursor-pointer" wire:click="$dispatch('closeModal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- content -->
    <div class="py-2">
        @isset($tweet)
            <div class="photos-slider-big">
                @foreach ($tweet->photos as $photo)
                    <!-- Card -->
                    <div class="photos-slider-card">
                        @switch(getMediaType($photo))
                            @case('video')
                                <video controls autoplay loop muted>
                                    <source src="{{ $photo->getUrl() }}" type="{{ $photo->mime_type }}">
                                </video>
                            @break
                            @default
                                <div class="img-container overflow-hidden border border-gray-200 rounded-lg">
                                    <img class="w-full" src="{{ $photo->getUrl() }}" alt="" />  
                                </div>
                            @break
                        @endswitch                        
                    </div>
                @endforeach
            </div>
        @endisset
    </div> 
    
    <script>
        //document.addEventListener('livewire:initialized', () => {
            // alert('hello');
            // $(".photos-slider-big").slick({
            //     dots: false,
            //     infinite: false,
            //     autoplay: false,
            //     slidesToShow: 1,
            //     slidesToScroll: 1,
            //     initialSlide: 1
            // })
        //})
    </script>
</div>

