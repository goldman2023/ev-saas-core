<!-- Features Section -->
<div class="border-bottom bg-white">
    <div class="container space-lg-1 space-1">
        <div class="row flex-nowrap ev-horizontal-slider" style="overflow: scroll;">            @for($i = 0; $i < 3; $i++)
            <div class="col-sm-4 col-5 mb-0">
                <!-- Contacts -->
{{--             TODO: Make this somehow dynamic    --}}
                <div class="media d-flex align-items-center">
                    <figure class="w-100 max-w-8rem mr-4">
                        <x-ev.dynamic-image class="img-fluid" :src="ev_dynamic_translate('#benefits-general-logo-' . $i, true)" alt="Any alt text" :widthInfos="[[300, '200w'], [1000, '1000w']]">
                        </x-ev.dynamic-image>
                    </figure>
                    <div class="media-body ">
                        <h4 class="mb-1">
                            <x-ev.label :label="ev_dynamic_translate('Benefit Title ' . $i, true)">
                            </x-ev.label>
                        </h4>
                        <div class="font-size-1 mb-0 d-none d-md-block">
                            <x-ev.label :label="ev_dynamic_translate('Benefit Content ' . $i, true)">
                            </x-ev.label>
                        </div>
                    </div>
                </div>
                <!-- End Contacts -->
            </div>
            @endfor

        </div>
    </div>
</div>
<!-- End Features Section -->
