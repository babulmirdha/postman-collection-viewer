    <aside class="w-64 bg-white border-r rounded p-4 shadow-md h-screen sticky top-0 overflow-y-auto">
        <h2 class="text-lg font-bold mb-4"> <a href="{{ route('postman.collections.index') }}"
                class="block px-3 py-2 rounded-md font-semibold text-indigo-700 hover:bg-indigo-100">
                Collections
            </a></h2>
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
