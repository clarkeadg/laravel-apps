@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Upload Photos') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:py-6">
        @relativeInclude('_navigation')

        <div class="bg-white p-6 border border-gray-300 border-t-0">
            <div class="py-4">
                <form method="POST" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <input class="" type="file" name="image">
                    </div>

                    <div>
                        <input class="mt-4 py-2 px-4 rounded-md text-white bg-blue-600" type="submit">
                    </div>
                </form>
            </div>

            <div class="py-4">
                @foreach (Auth::user()->photos as $photo)
                    <div class="py-2 flex gap-2 justify-between items-center">
                        <img src="{{ $photo->getUrl('thumb') }}"/>
                        <div class="flex gap-4">
                            @if (Auth::user()->photo_id != $photo->id)
                                <form method="POST" action="/settings/photos/set_main">
                                    @csrf
                                    <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                    <button type="submit" class="mt-4 py-2 px-4 rounded-md text-white bg-blue-600 text-xs md:text-sm">
                                        Set Main Photo
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="/settings/photos/delete">
                                @csrf
                                <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                <button type="submit" class="mt-4 py-2 px-4 rounded-md text-white bg-red-600 text-xs md:text-sm">
                                    Delete
                                </button>
                            </form>
                        </div> 
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
