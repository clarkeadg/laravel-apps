<div class="bg-white border border-gray-200 rounded-lg py-4 px-6 mb-4">
    <h2 class="text-lg font-bold mb-2">Description</h2>
    @foreach ($profile_groups["Description"] as $field)
        @isset($profile_data['field_'.$field->id])
            <p class="">
                {{ $profile_data['field_'.$field->id]['value'] }}
            </p>
        @endisset
    @endforeach
</div>