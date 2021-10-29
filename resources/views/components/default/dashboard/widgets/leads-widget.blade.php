<div class="card h-100">
    <div class="card-body">
        <h6 class="card-subtitle mb-2">{{ translate('Total Leads') }}</h6>

        <div class="row align-items-center gx-2">
            <div class="col">
                <span class="js-counter display-4 text-dark" data-value="24">
                    {{ App\Models\Lead::count() }}
                </span>
                <span class="text-body font-size-sm ml-1">{{ translate('from') }}
                    {{ App\Models\Lead::count() }}</span>
            </div>

            <div class="col-auto">
                <span class="badge badge-soft-success p-1 text-wrap">
                    <x-heroicon-o-trending-up class="ev-icon__small" />
                    <br>

                    {{ App\Models\Lead::trend() }} %
                </span>
            </div>
        </div>
        <!-- End Row -->
    </div>
    @if (strval($slot))
        <div class="card-footer">
            {{ $slot }}
        </div>
    @endif
</div>