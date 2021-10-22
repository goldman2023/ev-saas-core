<div class="card h-100">
    <div class="card-body">
        <figure class="max-w-8rem mb-3">
            <x-ev.dynamic-image class="img-fluid" :src="ev_dynamic_translate('#hero-benefit-image-'. $attributes['id'], true)" alt="Any alt text" :widthInfos="[[300, '200w'], [1000, '1000w']]">
            </x-ev.dynamic-image>

        </figure>
        <x-ev.label
        tag="h4"
        :label="ev_dynamic_translate($attributes['id'] . ' Title', true)">
        </x-ev.label>
        <p>
        <x-ev.label
        :label="ev_dynamic_translate($attributes['id'] . ' Description', true)">
        </x-ev.label>
        </p>
        <x-ev.link-button :href="ev_dynamic_translate('#button-'. $attributes['id'])"
                        :label="ev_dynamic_translate($attributes['id'] . 'Button 1')"
                        class="ev-button">
        <i class="fas fa-angle-right align-middle ml-1"></i>
        </x-ev.link-button>

    </div>
</div>
