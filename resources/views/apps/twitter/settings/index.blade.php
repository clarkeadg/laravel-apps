@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Profile') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="p-4 bg-white rounded-lg border border-gray-300">
            <div class="mb-4">
                <div class="mb-2">
                    <span class="ml-2 font-bold text-lg">{{ __('Profile') }}</span>
                </div>
                <a href="{{ route($app.'.settings.profile') }}" class="mb-1 py-3 px-4 flex w-full items-center justify-between bg-blue-100 hover:bg-blue-200 text-gray-600 rounded-lg">
                    <span>{{ __('Edit Profile') }}</span>
                    <div class="flex items-center">
                        <span class="mr-1">{{ Auth::user()->name }}</span>
                        <x-heroicon-o-chevron-right class="h-4 w-4"/>
                    </div>
                </a>
            </div>
            <div class="mb-4">
                <div class="mb-2">
                    <span class="ml-2 font-bold text-lg">{{ __('Security') }}</span>
                </div>
                <a href="{{ route($app.'.settings.email') }}" class="mb-1 py-3 px-4 flex w-full items-center justify-between bg-blue-100 hover:bg-blue-200 text-gray-600 rounded-lg">
                    <span>{{ __('Change Email') }}</span>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="h-4 w-4"/>
                    </div>
                </a>
                <a href="{{ route($app.'.settings.password') }}" class="mb-1 py-3 px-4 flex w-full items-center justify-between bg-blue-100 hover:bg-blue-200 text-gray-600 rounded-lg">
                    <span>{{ __('Change Password') }}</span>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="h-4 w-4"/>
                    </div>
                </a>
                <a href="{{ route($app.'.settings.sessions') }}" class="mb-1 py-3 px-4 flex w-full items-center justify-between bg-blue-100 hover:bg-blue-200 text-gray-600 rounded-lg">
                    <span>{{ __('Active Sessions') }}</span>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="h-4 w-4"/>
                    </div>
                </a>
            </div>
            <div class="mb-4">
                <div class="mb-2">
                    <span class="ml-2 font-bold text-lg">{{ __('Other options') }}</span>
                </div>
                <a href="{{ route($app.'.settings.account') }}" class="mb-1 py-3 px-4 flex w-full items-center justify-between bg-blue-100 hover:bg-blue-200 text-gray-600 rounded-lg">
                    <span>{{ __('Delete Account') }}</span>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="h-4 w-4"/>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
