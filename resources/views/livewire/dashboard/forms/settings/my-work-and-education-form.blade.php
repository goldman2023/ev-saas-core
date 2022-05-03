@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

<div class="w-full" x-data="{
        current: 'basicInformation',
        thumbnail: @js(['id' => $me->thumbnail->id ?? null, 'file_name' => $me->thumbnail->file_name ?? '']),
        cover: @js(['id' => $me->cover->id ?? null, 'file_name' => $me->cover->file_name ?? '']),
        meta: @js($meta),
        entity: @js($me->entity),
        onSave() {
            @if(collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true)->count() > 0)
                @foreach(collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true) as $key => $options)
                    @if($key === 'education' || $key === 'work_experience')
                        $wire.set('meta.{{ $key }}.value', this.meta.{{ $key }}.value, true);
                    @endif
                @endforeach
            @endif
        },
    }" x-init="$watch('current', function(value) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#'+value).offset().top - $('#topbar').outerHeight() - 20
        }, 500);
    })" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" 
        @submit-form.window="
            setTimeout(() => {
                $wire.saveAll();
            }, 500)
        "
        x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden">
        </x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">

            <div class="grid grid-cols-12 gap-8 mb-10">
                <div class="col-span-12 md:col-span-6 flex flex-col">
                    <label class="block text-18 font-semibold text-gray-700 pb-2 mb-3 border-b border-gray-200">
                        {{ translate('Work Experience') }}
                    </label>
                    <x-dashboard.form.blocks.work-experience-form field="meta.work_experience.value"></x-dashboard.form.blocks.work-experience-form>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-18 font-semibold text-gray-700 pb-2 mb-3 border-b border-gray-200">
                        {{ translate('Education') }}
                    </label>
                    <x-dashboard.form.blocks.education-form field="meta.education.value"></x-dashboard.form.blocks.education-form>
                </div>
            </div>
        </div>
    </div>
</div>
