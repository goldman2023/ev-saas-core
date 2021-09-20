<div>
    <!-- Media -->
    <a class="card text-center h-100 transition-3d-hover" href="#">
        <div class="card-body p-lg-5">
            <figure class="max-w-8rem w-100 mx-auto mb-4">
                <x-ev.dynamic-image class="avatar-img"
                :src="ev_dynamic_translate('#sales-agent-image', true)" alt="Sales agent image"
                :widthInfos="[[300, '200w'], [1000, '1000w']]">
            </x-ev.dynamic-image>
            </figure>
            <h3 class="h4">
                <x-ev.label :label="ev_dynamic_translate('Contact Widget Title', true)"></x-ev.label>
            </h3>
            <p class="text-body mb-0">
                <x-ev.label :label="ev_dynamic_translate('Contact Widget Description', true)"></x-ev.label>
            </p>
        </div>
        <div class="card-footer font-weight-bold py-3 px-lg-5">
            <x-ev.label :label="ev_dynamic_translate('Contact Widget CTA', true)"></x-ev.label>
        </div>
    </a>
    <!-- End Media -->
</div>
