@extends('apps.boosh._layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto">            
            <div class="px-10 flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($apps as $app)
                    <a href="{{ $app['url'] }}" target="_blank" class="image-hover">
                        <div class="bg-white border border-gray-200 rounded-lg shadow">                        
                            <!-- Image -->  
                            <div class="img-container rounded-t-lg overflow-hidden aspect-video flex items-center justify-center">
                                <img class="max-h-10" src="{{ $app['logo'] }}" alt="" />  
                            </div>
                            <!-- Info -->
                            <div class="p-4"> 
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-center text-gray-900 truncate">
                                    {{ $app['name'] }}
                                </h5> 
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>    
@endsection
