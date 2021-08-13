<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 text-gray-500 hover:text-gray-700 text-sm font-medium leading-5">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block w-auto h-10 text-gray-600 fill-current"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (get_setting('header_menu_labels') != null)
                        @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                            @php
                                $target = "_self";
                            @endphp
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                               class="inline-flex items-center px-1 pt-1  focus:outline-none"
                               target="{{$target}}">
                                {{ translate($value) }}
                            </a>
                        @endforeach
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-join-button></x-join-button>
                </div>
            </div>
            @endif
        </div>
    </div>
</nav>
