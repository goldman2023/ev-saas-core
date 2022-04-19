<div class="grid gap-8 grid-cols-{{ $per_row['mobile'] ?? 1 }}  sm:grid-cols-{{ $per_row['tablet'] ?? 2 }} lg:grid-cols-{{ $per_row['laptop'] ?? 3 }} xl:grid-cols-{{ $per_row['desktop'] ?? 3 }} {{ $class }}"
    x-data="{
        itt_group: @js($ittGroup)
    }">
    {!! $slot !!}
</div>