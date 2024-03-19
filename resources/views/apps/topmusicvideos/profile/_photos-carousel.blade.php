<div class="px-10 mb-4">
    <div class="photos-slider hidden">
        @foreach ($profile->photos as $photo)
            <!-- Card -->
            <a class="photos-slider-card px-2" href="#" data-index="{{ $loop->index }}">
                <!-- Image -->
                <div class="image-hover img-container overflow-hidden border border-gray-200 rounded-lg">
                    <img class="w-full" src="{{ $photo->getUrl('thumb') }}" alt="" />  
                </div>
            </a>
        @endforeach
    </div>
</div>