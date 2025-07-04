@extends('layouts.app')

@section('content')
    <div class="flex max-w-7xl mx-auto gap-6">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r rounded p-4 shadow-md h-screen sticky top-0 overflow-y-auto">
            <h2 class="text-lg font-bold mb-4"><a href="{{ route('postman.collections.index') }}"
                    class="block px-3 py-2 rounded-md font-semibold text-indigo-700 hover:bg-indigo-100">
                    Collections
                </a></h2>
            {{-- You can list folders here if needed --}}


            <ul class="space-y-2">




                <li>
                    <a href="{{ route('postman.environments.index') }}"
                        class="block px-3 py-2 rounded-md font-semibold text-indigo-700 hover:bg-indigo-100">
                        Environment Variables
                    </a>
                </li>


                <li>
                    <a href="{{ route('postman.collections.upload') }}"
                        class="block px-3 py-2 rounded-md font-semibold text-indigo-700 hover:bg-indigo-100">
                        Upload Collection
                    </a>
                </li>

                <li>
                    <a href="{{ route('postman.environments.upload') }}"
                        class="block px-3 py-2 rounded-md font-semibold text-indigo-700 hover:bg-indigo-100">
                        Upload Environment
                    </a>
                </li>



            </ul>

        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-2xl font-semibold mb-6">Postman Collections</h2>

            @if ($collections && count($collections))
                <div class="space-y-4">
                    @foreach ($collections as $collection)
                        <div
                            class="bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 flex items-center justify-between hover:shadow-md transition group">

                            {{-- Left: Collection Info as clickable link --}}
                            <a href="{{ route('postman.collections.show', ['id' => $collection['path']]) }}"
                                class="flex-1 cursor-pointer" title="View collection: {{ $collection['name'] }}">
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600">
                                    {{ $collection['name'] }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $collection['path'] }}</p>
                            </a>

                            {{-- Right: Action Buttons --}}
                            <div class="flex flex-col gap-2 items-end ml-6">
                                <a href="{{ route('postman.collections.show', ['id' => $collection['path']]) }}"
                                    class="px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm w-28 text-center">
                                    View
                                </a>

                                <a href="{{ route('postman.collections.download', ['id' => $collection['path']]) }}"
                                    class="px-4 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm w-28 text-center">
                                    Download
                                </a>

                                <form action="{{ route('postman.collections.delete', ['id' => $collection['path']]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this collection?');"
                                    class="w-28">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm w-full">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500">No collections found.</div>
            @endif

        </main>
    </div>
@endsection
