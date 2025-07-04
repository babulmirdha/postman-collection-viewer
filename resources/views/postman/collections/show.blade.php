@extends('layouts.app')

@section('content')

    <div class="flex max-w-7xl mx-auto gap-6">

        {{-- Sidebar: Fixed Navigation --}}
        <aside class="w-64 bg-white border-r rounded p-4 shadow-md h-screen sticky top-0 overflow-y-auto">
            <h2 class="text-lg font-bold mb-4"> <a href="{{ route('postman.collections.index') }}">Collections</a> </h2>
            <ul class="space-y-2">
                @foreach ($groups as $index => $group)
                    <li>
                        <a href="{{ route('postman.collections.show', [ 'id' => $id, 'folder' => $index]) }}"
                            class="block px-3 py-2 rounded-md font-semibold
                              {{ $index == $selectedIndex ? 'bg-indigo-600 text-white' : 'text-indigo-700 hover:bg-indigo-100' }}">
                            {{ $group['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        {{-- Content Area --}}
        <main class="flex-1">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if ($selectedGroup)
                <h3 class="text-2xl font-bold text-indigo-800 mb-6">
                    {{ $selectedGroup['name'] }}
                </h3>

                @foreach ($selectedGroup['items'] as $item)
                    @php
                        $request = $item['request'] ?? null;
                        $method = strtoupper($request['method'] ?? '');
                        $methodColors = [
                            'GET' => 'bg-green-100 text-green-600',
                            'POST' => 'bg-blue-100 text-blue-600',
                            'PUT' => 'bg-orange-100 text-orange-600',
                            'DELETE' => 'bg-red-100 text-red-600',
                            'PATCH' => 'bg-yellow-100 text-yellow-600',
                            'HEAD' => 'bg-indigo-100 text-indigo-600',
                        ];
                        $methodClass = $methodColors[$method] ?? 'bg-gray-100 text-gray-600';

                        $hasBearer = false;
                        $token = $token ?? '';

                        if (!empty($request['header'])) {
                            foreach ($request['header'] as $header) {
                                if (
                                    strtolower($header['key']) === 'authorization' &&
                                    str_starts_with(strtolower($header['value']), 'bearer')
                                ) {
                                    $hasBearer = true;
                                }
                            }
                        }

                        if (isset($request['auth']) && $request['auth']['type'] === 'bearer') {
                            $hasBearer = true;
                            $token = $request['auth']['bearer'][0]['value'] ?? $token;
                        }

                        $resolvedUrl = str_replace('{{base_url}}', $base_url, $request['url']['raw'] ?? '');
                    @endphp

                    <article class="border border-gray-200 rounded-lg shadow-sm bg-white mb-6">
                        <header class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                            <h4 class="text-lg font-semibold text-gray-800">{{ $item['name'] ?? 'Unnamed Request' }}</h4>
                        </header>

                        <div class="px-4 py-4 space-y-3">
                            @if ($request)
                                <div>
                                    <span class="font-medium text-gray-700">Method:</span>
                                    <span class="px-2 py-1 rounded text-xs font-bold font-mono uppercase {{ $methodClass }}">
                                        {{ $method }}
                                    </span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">URL:</span>
                                    <span class="text-gray-900 break-all">{{ $resolvedUrl }}</span>
                                </div>

                                @if ($hasBearer)
                                    <div>
                                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                            🔒 Requires Bearer Token
                                        </span>

                                        @if ($token)
                                            <div class="mt-1 text-sm font-mono text-gray-800 bg-gray-100 px-3 py-2 rounded break-all">
                                                {{ Str::limit($token, 12, '...') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if (!empty($request['header']))
                                    <div>
                                        <span class="font-medium text-gray-700">Headers:</span>
                                        <ul class="list-disc pl-6 mt-1 space-y-1 text-sm text-gray-600">
                                            @foreach ($request['header'] as $header)
                                                <li>
                                                    <strong>{{ $header['key'] }}:</strong> {{ $header['value'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (!empty($request['body']['raw']))
                                    <div>
                                        <span class="font-medium text-gray-700">Body:</span>
                                        <pre class="bg-gray-100 text-sm text-gray-800 mt-1 p-3 rounded-md overflow-auto whitespace-pre-wrap">{!! \App\Http\Controllers\Postman\JsonUtils::prettyJson($request['body']['raw']) !!}</pre>
                                    </div>
                                @endif

                                {{-- Test Button and Expandable Form --}}
                                <div>
                                    <button onclick="document.getElementById('test-form-{{ $loop->index }}').classList.toggle('hidden')"
                                            class="mt-2 inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded text-sm">
                                        🚀 Test API
                                    </button>

                                    @php
                                    //   dd(route('postman.test'))
                                    @endphp

                                    <form id="test-form-{{ $loop->index }}" class="hidden mt-4 space-y-4" method="POST" action="{{ route('postman.test') }}">
                                        @csrf
                                        <input type="hidden" name="method" value="{{ $method }}">

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Request URL</label>
                                            <input type="text" name="url" value="{{ $resolvedUrl }}"
                                                   class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Token</label>
                                            <input type="text" name="token" value="{{ $token }}"
                                                   class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Request Body (JSON)</label>
                                            <textarea name="body" rows="4" class="w-full mt-1 px-3 py-2 border rounded-md text-sm">{{ $request['body']['raw'] ?? '' }}</textarea>
                                        </div>

                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                                            ▶️ Run
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if (!empty($item['response']))
                                <div>
                                    <span class="font-medium text-gray-700">Example Responses:</span>
                                    @foreach ($item['response'] as $resp)
                                        <div class="bg-blue-50 border border-blue-200 mt-2 p-3 rounded-md">
                                            <p class="text-sm text-blue-800"><strong>Status:</strong> {{ $resp['status'] ?? '' }}</p>
                                            @if (!empty($resp['body']))
                                                <pre class="bg-white border border-gray-200 text-sm text-gray-800 mt-1 p-2 rounded overflow-auto whitespace-pre-wrap">{{ $resp['body'] }}</pre>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            @else
                <p class="text-gray-600">No group selected or group is empty.</p>
            @endif
        </main>
    </div>
@endsection
