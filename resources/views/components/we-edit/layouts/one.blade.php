<main class="min-w-0 flex-1 border-t border-gray-200 lg:flex">
    <!-- Primary column -->
    <section class="w-full min-w-0 flex-1 h-full flex flex-col overflow-y-auto lg:order-last">
        <div class="h-full relative flex flex-col w-full border-r border-gray-200 bg-gray-100 overflow-y-auto">
            {{ $slot }}
        </div>
    </section>
</main>