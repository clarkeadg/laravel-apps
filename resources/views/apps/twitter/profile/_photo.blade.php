<div class="relative h-60 flex w-full items-end justify-end mb-4" style="background: url({{ $profile->cover_photo }}) no-repeat center top / 100% auto;">
    <div class="absolute left-5 -bottom-10">
        <div class="inline-block img-container overflow-hidden">    
            <img class="w-24 h-24 rounded-full object-cover border-4 border-white" src="{{ $profile->avatar }}" alt="{{ $profile->name }}" />
        </div>
    </div>            
</div>