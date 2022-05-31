<div class="text-5xl font-bold leading-none text-gray-100 ">
    <div class="">Welcome to</div>
    <div class="">our community</div>
</div>
<div class="mt-6 text-lg tracking-tight leading-6 text-gray-400 ">
    {{ get_tenant_setting('Join the global community of likeminded people') }}
</div>
<div class="flex items-center mt-8 ">
    <div class="flex flex-0 items-center -space-x-1.5 ">
        @for($i = 0; $i < 4; $i++) <img
            src="/images/male-09.jpeg"
            class="flex-0 w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover ">
            @endfor
    </div>
    <div class="ml-4 font-medium tracking-tight text-gray-400 ">
        {{ translate('More than') }} {{ get_public_user_count() }}
        {{ translate('people joined us, it\'s your turn') }}</div>
</div>
