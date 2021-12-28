<div class="bg-img-hero-center bg-primary"
    style="background-image: url(https://htmlstream.com/preview/front-v3.1.1/assets/img/1920x800/img8.jpg);">
    <div class="container space-1 space-lg-1">
        <div class="w-md-65 w-lg-35">
            <div class="mb-4">
                <x-ev.label tag="h2" class="h1 text-white" :label="ev_dynamic_translate('Category hero title', true)">
                </x-ev.label>
                <x-ev.label tag="span" class="text-white"
                    :label="ev_dynamic_translate('Category hero descrioption', true)">
                </x-ev.label>
            </div>

            <x-ev.link-button :href="ev_dynamic_translate('#category-hero-button1, true')"
                :label="ev_dynamic_translate('Shop the Collection', true)"
                class="ev-button btn btn-light btn-pill transition-3d-hover px-5 text-dark">
            </x-ev.link-button>
        </div>
    </div>
</div>
