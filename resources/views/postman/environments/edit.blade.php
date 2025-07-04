@extends('layouts.app')

@section('content')
<div class="flex max-w-4xl mx-auto gap-6">

    {{-- Sidebar Navigation --}}
    @include('postman.partials.settings_sidebar')

    {{-- Content Area --}}
    <main class="flex-1">
        <h3 class="text-2xl font-bold text-indigo-800 mb-6">Edit Postman Environment</h3>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('postman.environment.update-variables') }}"
              class="bg-white p-6 rounded-lg shadow border space-y-4">
            @csrf

            @foreach($environment['values'] ?? [] as $index => $env)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $env['key'] }}
                    </label>
                    <input type="hidden" name="env[{{ $index }}][key]" value="{{ $env['key'] }}">
                    <input type="text" name="env[{{ $index }}][value]"
                           value="{{ $env['value'] }}"
                           class="block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            @endforeach

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition font-semibold">
                Save Environment
            </button>
        </form>
    </main>
</div>
@endsection
