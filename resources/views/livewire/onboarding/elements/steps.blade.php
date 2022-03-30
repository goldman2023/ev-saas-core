<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="flex items-center justify-center" aria-label="Progress">
        <p class="text-sm font-medium">Step 2 of 4</p>
        <ol role="list" class="ml-8 flex items-center space-x-5">
            <li>
                <!-- Completed Step -->
                <a href="#" class="block w-2.5 h-2.5 bg-indigo-600 rounded-full hover:bg-indigo-900">
                    <span class="sr-only">Step 1</span>
                </a>
            </li>

            <li>
                <!-- Current Step -->
                <a href="#" class="relative flex items-center justify-center" aria-current="step">
                    <span class="absolute w-5 h-5 p-px flex" aria-hidden="true">
                        <span class="w-full h-full rounded-full bg-indigo-200"></span>
                    </span>
                    <span class="relative block w-2.5 h-2.5 bg-indigo-600 rounded-full" aria-hidden="true"></span>
                    <span class="sr-only">Step 2</span>
                </a>
            </li>

            <li>
                <!-- Upcoming Step -->
                <a href="#" class="block w-2.5 h-2.5 bg-gray-200 rounded-full hover:bg-gray-400">
                    <span class="sr-only">Step 3</span>
                </a>
            </li>

            <li>
                <!-- Upcoming Step -->
                <a href="#" class="block w-2.5 h-2.5 bg-gray-200 rounded-full hover:bg-gray-400">
                    <span class="sr-only">Step 4</span>
                </a>
            </li>
        </ol>
    </nav>

</div>
