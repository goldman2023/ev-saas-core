<div x-data="{
    category: @entangle('category').defer,
}">
    <div class="col-lg-12 position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="saveCategory"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <div class=""
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="saveCategory"
        >

            <!-- Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper"
                     x-data="{
                        name: 'category.cover',
                        imageID: {{ $category->cover->id ?? 'null' }},
                        imageURL: '{{ $category->getCover(['w'=>1200]) }}',
                    }"
                     @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('category.cover', $('input[name=\'category.cover\']').val(), true);
                     }"
                     data-toggle="aizuploader"
                     data-type="image">

                    <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">

                    <!-- Custom File Cover -->
                    <div class="profile-cover-content profile-cover-btn custom-file-manager"
                         data-toggle="aizuploader" data-type="image">
                        <div class="custom-file-btn">
                            <input type="hidden" x-bind:name="name" wire:model.defer="category.cover" class="selected-files" data-preview-width="1200">

                            <label class="custom-file-btn-label btn btn-sm btn-white shadow-lg d-flex align-items-center" for="profileCoverUploader">
                                @svg('heroicon-o-pencil', ['class' => 'square-16 mr-2'])
                                <span class="d-none d-sm-inline-block">{{ translate('Update category cover') }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- End Custom File Cover -->
                </div>
            </div>
            <!-- End Cover -->

            <!-- Thumbnail -->
            <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader mx-auto profile-cover-avatar pointer border p-1" for="avatarUploader"
                   style="margin-top: -60px;"
                   x-data="{
                        name: 'category.thumbnail',
                        imageID: {{ $category->thumbnail->id ?? 'null' }},
                        imageURL: '{{ $category->getThumbnail() }}',
                    }"
                   @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('category.thumbnail', $('input[name=\'category.thumbnail\']').val(), true);
                     }"
                   data-toggle="aizuploader"
                   data-type="image">
                <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                <input type="hidden" x-bind:name="name" wire:model.defer="category.thumbnail" class="selected-files" data-preview-width="200">

                <span class="avatar-uploader-trigger">
                  <i class="avatar-uploader-icon shadow-soft">
                      @svg('heroicon-o-pencil', ['class' => 'square-16'])
                  </i>
                </span>
            </label>
            <!-- End Thumbnail -->

            <x-default.system.invalid-msg field="category.thumbnail"></x-default.system.invalid-msg>

            <x-default.system.invalid-msg field="category.cover"></x-default.system.invalid-msg>

            <!-- Name -->
            <div class="row form-group mt-5">
                <label for="category-name" class="col-sm-3 col-form-label input-label">{{ translate('Name') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('category.name') is-invalid @enderror"
                               name="category.name"
                               id="category-name"
                               placeholder="{{ translate('New category name') }}"
                               wire:model.defer="category.name" />
                    </div>

                    <x-default.system.invalid-msg field="category.name"></x-default.system.invalid-msg>
                </div>
            </div>
            <!-- END Name -->


            <div class="row form-group"
                 x-data="{ parent_id: null }"
                 x-init="
                    $($refs.parent_category_selector).on('select2:select', (event) => {
                        parent_id = event.target.value;
                    });
                    $watch('parent_id', (value) => {
                      $($refs.parent_category_selector).val(value).trigger('change');
{{--                        $wire.call('bulkAction', $($refs.bulk_permission_actions).val());--}}
                     });
            ">

                <label for="category-name" class="col-sm-3 col-form-label input-label">{{ translate('Parent category') }}</label>

                <div class="col-sm-9">
                    <!-- Select -->
                    <select class="js-select2-custom js-datatable-filter custom-select" size="1" style=""
                            id="parent_category_selector"
                            data-target-column-index="1"
                            data-hs-select2-options='{
                              "minimumResultsForSearch": "1",
                              "customClass": "custom-select custom-select-sm",
                              "dropdownAutoWidth": true,
                              "width": true,
                              "dropdownCssClass": "no-max-height"
{{--                              "placeholder": "{{ translate('Select parent category...') }}"--}}
                            }'
                            x-ref="parent_category_selector"
                            wire:model.defer="category.parent_id"
                    >
                        <option value="" {{ empty($category->parent_id) ? 'selected':'' }}>{{ translate('No parent category') }}</option>
                        @foreach(Categories::getAll(true) as $item)
                            <option value="{{ $item->id }}">{{ str_repeat('-', $item->level).$item->getTranslation('name') }}</option>
                        @endforeach
                    </select>
                    <!-- End Select -->

                    <x-default.system.invalid-msg field="category.parent_id"></x-default.system.invalid-msg>
                </div>
            </div>

            <div class="row form-group">
                <label for="category-featured" class="col-sm-3 col-form-label input-label">{{ translate('Featured') }}</label>

                <div class="col-sm-9 d-flex align-items-center">
                    <!-- Checkbox Switch -->
                    <label class="toggle-switch d-flex align-items-center" for="category-featured">
                        <input type="checkbox" class="toggle-switch-input" id="category-featured" wire:model.defer="category.featured">
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                          </span>
                        <span class="toggle-switch-content">
                            <span class="d-block">{{ translate('Featured') }}</span>
                          </span>
                    </label>
                    <!-- End Checkbox Switch -->
                </div>
            </div>

            <div class="row form-group">
                <div for="category-featured" class="col-sm-3 col-form-label input-label">{{ translate('Icon') }}</div>

                <div class="col-sm-9 d-flex align-items-center">
                    <!-- Icon -->

                    <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar pointer border p-1 mb-0 mt-0" for="avatarUploader"
                           style="width: 65px; height: 65px;"
                           x-data="{
                                name: 'category.icon',
                                imageID: {{ $category->icon?->id ?? 'null' }},
                                imageURL: '{{ $category->getUpload('icon', ['w'=>100]) }}',
                            }"
                           @aiz-selected.window="
                             if(event.detail.name === name) {
                                imageURL = event.detail.imageURL;
                                $wire.set('category.icon', $('input[name=\'category.icon\']').val(), true);
                             }"
                           data-toggle="aizuploader"
                           data-type="image">
                        <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                        <input type="hidden" x-bind:name="name" wire:model.defer="category.icon" class="selected-files" data-preview-width="200">

{{--                        <span class="avatar-uploader-trigger">--}}
{{--                          <i class="avatar-uploader-icon shadow-soft">--}}
{{--                              @svg('heroicon-o-pencil', ['class' => 'square-16'])--}}
{{--                          </i>--}}
{{--                        </span>--}}
                    </label>
                    <!-- End Icon -->

                    <x-default.system.invalid-msg class="ml-3" field="category.icon"></x-default.system.invalid-msg>
                </div>

            </div>



            <!-- Meta Title -->
            <div class="row form-group">
                <label for="category-meta_title" class="col-sm-3 col-form-label input-label">{{ translate('Meta title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('category.meta_title') is-invalid @enderror"
                               name="category.meta_title"
                               id="category-meta_title"
                               placeholder="{{ translate('Category SEO/meta title') }}"
                               wire:model.defer="category.meta_title" />
                    </div>
                </div>

                <x-default.system.invalid-msg field="category.meta_title"></x-default.system.invalid-msg>
            </div>
            <!-- END Meta Title -->

            <!-- Meta Description -->
            <div class="row form-group">
                <label for="category-meta_description" class="col-sm-3 col-form-label input-label">{{ translate('Meta description') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('category.meta_description') is-invalid @enderror"
                                  name="category.meta_description"
                                  id="category-meta_description"
                                  placeholder="{{ translate('Category SEO/meta description') }}"
                                  wire:model.defer="category.meta_description">
                        </textarea>
                    </div>
                </div>

                <x-default.system.invalid-msg field="category.meta_description"></x-default.system.invalid-msg>
            </div>
            <!-- END Name -->


            <hr/>
            <div class="row form-group mb-0">
                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="$wire.set('category.parent_id', $('#parent_category_selector').val(), true); $wire.saveCategory();">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
