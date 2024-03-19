@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto sm:py-6">
        @if($profile->is_my_profile)
            @include('apps.'.$app.'.settings._navigation')
        @endif
        <div class="bg-white p-6 border border-gray-300 @if($profile->is_my_profile) border-t-0 @endif">
            <div class="pb-6">
                <h2 class="font-semibold text-xl text-blue-400 leading-tight flex justify-center items-center">
                    {{ $profile->name }}
                    @livewire('user.user-online', ['userId' => $profile->id])
                </h2>
            </div>  
            <!-- Profile -->
            <div class="">
                @relativeInclude('_essentials')
                @relativeInclude('_photo')
                @relativeInclude('_photos-carousel')
                @relativeInclude('_basics')
                @relativeInclude('_about')
                @relativeInclude('_description')
            </div>
        </div>
    </div>
    @relativeInclude('_photos-modal')
@endsection
