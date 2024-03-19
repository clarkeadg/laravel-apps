<x-guest-layout>
    <div class="flex flex-col items-center p-5">
        <x-authentication-card-logo />
        <div class="max-w-4xl w-full mt-6 p-6 bg-white shadow-md overflow-hidden rounded-lg prose">
            {!! $policy !!}
        </div>
    </div>
</x-guest-layout>
