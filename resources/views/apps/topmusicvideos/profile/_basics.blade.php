<div class="bg-white border border-gray-200 rounded-lg py-4 px-6 mb-4">
    <h2 class="text-lg font-bold mb-2">The Basics</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2">
        @foreach ($profile_groups["The Basics"] as $field)
            @isset($profile_data['field_'.$field->id])
                <div class="flex space-between">
                    <div class="w-1/2 text-blue-400 font-bold mb-2">
                        {{ $field->title }}
                    </div>
                    <div class="w-1/2 ">
                        {{ $profile_data['field_'.$field->id]['value'] }}
                    </div>
                </div>
            @endisset
        @endforeach
    </div>
</div>