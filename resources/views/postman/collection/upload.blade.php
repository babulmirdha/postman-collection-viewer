@extends('layouts.app')

@section('content')
<div class="flex max-w-7xl mx-auto gap-6">

    {{-- Sidebar: Fixed Navigation --}}
        @include('postman.partials.settings_sidebar')

    {{-- Content Area --}}
    <main class="flex-1 space-y-10">
        {{-- Upload Collection --}}
        <section>
            <h3 class="text-2xl font-bold text-indigo-800 mb-4">Upload Postman Collection</h3>

            @if ($errors->has('postman_collection'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4 border border-red-200">
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        @foreach ($errors->get('postman_collection') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('postman.collection.upload') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow border space-y-4">
                @csrf

                <div>
                    <label for="postman_collection" class="block text-sm font-medium text-gray-700 mb-1">Select Postman Collection JSON File</label>
                    <input type="file" name="postman_collection" id="postman_collection" required
                           class="block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition font-semibold">
                    Submit
                </button>
            </form>
        </section>



    </main>
</div>
@endsection
