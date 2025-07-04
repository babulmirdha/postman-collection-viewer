@extends('layouts.app')

@section('content')
    <div class="flex max-w-4xl mx-auto gap-6">

        {{-- Sidebar Navigation --}}
        @include('postman.partials.settings_sidebar')

        {{-- Content Area --}}
        <main class="flex-1">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-indigo-800">
                    Environment Variables
                </h3>

                <a href="{{ route('postman.environment.edit-variables') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-indigo-700 transition">
                    ✏️ Edit Variables
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($environment['values'] ?? [] as $index => $env)
                    <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-4 font-mono text-sm">
                        <div class="flex justify-between items-center">
                            <div class="text-blue-700 font-semibold break-all">
                                "{{ $env['key'] }}"
                            </div>
                            <div class="text-green-700 text-right break-all">
                                "{{ $env['value'] }}"
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No environment variables found.</p>
                @endforelse
            </div>
        </main>
    </div>
@endsection
