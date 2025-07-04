@extends('layouts.app')

@section('content')
    <div class="flex max-w-7xl mx-auto gap-6">

        {{-- Sidebar: Fixed Navigation --}}
        <aside class="w-64 bg-white border-r rounded p-4 shadow-md h-screen sticky top-0 overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Folders</h2>

            </ul>
        </aside>

        {{-- Content Area --}}
        <main class="flex-1">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <h2>Uploaded Postman Collections</h2>
            <ul class="list-group mt-4">
                @forelse($collections as $collection)
                    <li class="list-group-item">
                        <strong>{{ $collection['name'] }}</strong> <br>
                        <small>{{ $collection['path'] }}</small>
                    </li>
                @empty
                    <li class="list-group-item">No collections found.</li>
                @endforelse
            </ul>

        </main>
    </div>
@endsection
