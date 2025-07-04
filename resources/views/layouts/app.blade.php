<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Postman Viewer')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <header class="bg-white shadow-md py-4 px-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-indigo-600">  <a href="{{ route('postman.collections.index') }}" class="text-indigo-600 hover:underline font-medium">API Documentations</a> </h1>
            <div>

            </div>
        </div>
    </header>


    <main class="p-6">
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-12 text-gray-600 text-sm py-6 px-6">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
            <div class="text-gray-400 text-xs italic">
                Developed by <span class="font-semibold">Babul Mirdha</span>
            </div>
            <div class="flex space-x-6">
                <a href="https://github.com/yourusername" target="_blank" rel="noopener"
                    class="text-indigo-600 hover:text-indigo-800 hover:underline transition">
                    GitHub
                </a>
                <a href="https://youtube.com/yourhandle" target="_blank" rel="noopener"
                    class="text-indigo-600 hover:text-indigo-800 hover:underline transition">
                    YouTube
                </a>
            </div>
        </div>
    </footer>



</body>

</html>
