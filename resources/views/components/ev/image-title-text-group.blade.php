<div class="grid gap-8 grid-cols-{{ round(12 / ($per_row['mobile'] ?? 1)) }}  sm:grid-cols-{{ round(12 / ($per_row['tablet'] ?? 2)) }} lg:grid-cols-{{ round(12 / ($per_row['laptop'] ?? 3)) }} xl:grid-cols-{{ round(12 / ($per_row['desktop'] ?? 4)) }} {{ $class }}"
    x-data="{
        itt_group: @js($ittGroup)
    }">
    {!! $slot !!}
</div>