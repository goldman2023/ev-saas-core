<main class="min-w-0 flex-1 border-t border-gray-200 lg:flex">
    <!-- Primary column -->
    <section class="w-[75%] min-w-0 flex-1 h-full flex flex-col overflow-y-auto lg:order-last">
        <div class="h-full relative flex flex-col w-full border-r border-gray-200 bg-gray-100 overflow-y-auto">
            {{ $second_column }}
        </div>
    </section>

    <!-- First column (hidden on smaller screens) -->
    <aside class="w-[25%] hidden lg:block lg:flex-shrink-0 lg:order-first">
        <div class="h-full relative flex flex-col w-full border-r border-gray-200 bg-gray-100 overflow-y-auto">
            {{ $first_column }}
        </div>
    </aside>
</main>