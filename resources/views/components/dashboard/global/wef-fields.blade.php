<div>
    <div class="flex flex-col py-2" x-data="{}">
        <livewire:dashboard.forms.wef.single-wef-form
        :subject="$model"
        wef-key="{{ $modelField }}"
            wef-label="Hide header" data-type="boolean" form-type="plain_text" positioning="vertical"
            key="{{ \UUID::generate(4)->string }}" />
    </div>


    <div class="flex flex-col py-2" x-data="{}">
        <livewire:dashboard.forms.wef.single-wef-form
        :subject="$model"
        wef-key="{{ $modelField }}"
            wef-label="Hide header" data-type="boolean" form-type="plain_text" positioning="vertical"
            key="{{ \UUID::generate(4)->string }}" />
    </div>

</div>
