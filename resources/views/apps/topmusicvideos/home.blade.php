@extends('apps.'.$app.'._layout')

@section('content')
    @relativeInclude('home._hero-carousel')

    <div class="max-w-7xl mx-auto"> 
        <div class="mt-5 mb-10">
            @foreach ($categories as $category)
                <div class="mb-4">
                    <h2 class="text-3xl flex justify-start items-center mb-4 pr-8">
                        <span class="px-4">{{ $category['name'] }}</span>
                        <span class="divider-line2 bg-black h-0.5 w-full"/>
                    </h2>
                    @relativeInclude('home._category-carousel')
                </div>
            @endforeach
        </div>
    </div>
@endsection
