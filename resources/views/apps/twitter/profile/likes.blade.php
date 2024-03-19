@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-300">
            @relativeInclude('_header')
            <div class="p-4">
                @relativeInclude('_navigation')
                @livewire('reactions.reactions-list', [
                    'app' => $app,
                    'name' => 'like',
                    'profile_id' => $profile->id,
                    'object_type' => 'App\Models\Tweet',
                    'object_id' => $profile->id,
                    'view' => 'profile'
                ])
            </div>
        </div>
    </div>
@endsection
