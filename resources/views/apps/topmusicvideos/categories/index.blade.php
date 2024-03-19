@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
        {{ __('Categories') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="px-10 flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($categories as $category) 
                    @include('apps.'.$app.'.cards.category')
                @endforeach
            </div>
        </div>
    </div>
@endsection
