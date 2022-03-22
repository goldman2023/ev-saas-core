<div {{ $attributes }} class="lg:col-span-1 rounded-lg bg-white overflow-hidden shadow px-4 py-5">
    <div class="card-header text-lg font-medium text-gray-900" >
        {{ $cardHeader }}
    </div>

    @isset($cardBody)
    <div class="card-body">
        {{ $cardBody }}
    </div>
    @endisset
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->

    @empty(!$cardFooter)
    <div class="card-footer mt-6 flex flex-col justify-stretch">
        {{ $cardFooter }}
    </div>
    @endempty
</div>
