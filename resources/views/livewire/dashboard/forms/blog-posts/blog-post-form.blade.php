@push('pre_head_scripts')
    <script>
        let all_categories = @json(Categories::getAllFormatted());
    </script>
@endpush

<div x-data="{
    blogPost: @entangle('blogPost').defer,
}"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>
    <div class="col-lg-12 position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="saveBlogPost"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <div class=""
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="saveBlogPost">

            <!-- Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper"
                     x-data="{
                        name: 'blogPost.cover',
                        imageID: {{ $blogPost->cover->id ?? 'null' }},
                        imageURL: '{{ $blogPost->getCover(['w'=>1200]) }}',
                    }"
                     @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('blogPost.cover', $('input[name=\'blogPost.cover\']').val(), true);
                     }"
                     data-toggle="aizuploader"
                     data-type="image">

                    <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">

                    <!-- Custom File Cover -->
                    <div class="profile-cover-content profile-cover-btn custom-file-manager"
                         data-toggle="aizuploader" data-type="image">
                        <div class="custom-file-btn">
                            <input type="hidden" x-bind:name="name" wire:model.defer="blogPost.cover" class="selected-files" data-preview-width="1200">

                            <label class="custom-file-btn-label btn btn-sm btn-white shadow-lg d-flex align-items-center" for="profileCoverUploader">
                                @svg('heroicon-o-pencil', ['class' => 'square-16 mr-2'])
                                <span class="d-none d-sm-inline-block">{{ translate('Update post cover') }}</span>
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
                        name: 'blogPost.thumbnail',
                        imageID: {{ $blogPost->thumbnail->id ?? 'null' }},
                        imageURL: '{{ $blogPost->getThumbnail() }}',
                    }"
                   @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('blogPost.thumbnail', $('input[name=\'blogPost.thumbnail\']').val(), true);
                     }"
                   data-toggle="aizuploader"
                   data-type="image">
                <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                <input type="hidden" x-bind:name="name" wire:model.defer="blogPost.thumbnail" class="selected-files" data-preview-width="200">

                <span class="avatar-uploader-trigger">
                  <i class="avatar-uploader-icon shadow-soft">
                      @svg('heroicon-o-pencil', ['class' => 'square-16'])
                  </i>
                </span>
            </label>
            <!-- End Thumbnail -->

            <x-system.invalid-msg field="blogPost.thumbnail"></x-system.invalid-msg>

            <x-system.invalid-msg field="blogPost.cover"></x-system.invalid-msg>

            <!-- Title -->
            <div class="row form-group mt-5" x-data="{
{{--                url_template: '{{ route('shop.blog.post.index', ['%shop_slug%', '%slug%'], false) }}',--}}
{{--                url: '',--}}
{{--                generateURL($slug) {--}}
{{--                    this.url = this.url_template.replace('%shop_slug%', '{{ MyShop::getShop()->slug ?? '' }}').replace('%slug%', '<strong>'+$slug.slugify()+'</strong>');--}}
{{--                }--}}
            }"
{{--            @initSlugGeneration.window="this.generateURL($('#blogPost-title').val())">--}}
                >

                <label for="blogPost-title" class="col-sm-3 col-form-label input-label">{{ translate('Title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('blogPost.title') is-invalid @enderror"
                               name="blogPost.title"
                               id="blogPost-title"
                               placeholder="{{ translate('New post title') }}"
{{--                               @input="generateURL($($el).val())"--}}
                               wire:model.defer="blogPost.title" />
                    </div>

{{--                    <div class="w-100 d-flex align-items-center mt-2">--}}
{{--                        <strong class="mr-2">{{ translate('URL') }}:</strong>--}}
{{--                        <span x-html="(url !== undefined) ? url : ''"></span>--}}
{{--                    </div>--}}

                    <x-system.invalid-msg field="blogPost.title"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Title -->

            <!-- Status -->
            <div class="row form-group mt-5">
                <label for="blogPost-status" class="col-sm-3 col-form-label input-label">{{ translate('Status') }}</label>

                <div class="col-sm-9" x-data="{
                        status: @js($blogPost->status ?? App\Enums\StatusEnum::draft()->value),
                    }"
                     x-init="
                        $($refs.blogPost_status_selector).on('select2:select', (event) => {
                          status = event.target.value;
                        });

                        $watch('status', (value) => {
                          $($refs.blogPost_status_selector).val(value).trigger('change');
                        });
                     ">
                    <select
                        wire:model.defer="blogPost.status"
                        name="blogPost.status"
                        x-ref="blogPost_status_selector"
                        id="blog-post-status-selector"
                        class="js-select2-custom custom-select select2-hidden-accessible"
                        data-hs-select2-options='
                            {"minimumResultsForSearch":"Infinity"}
                        '
                    >
                        @foreach(\App\Enums\StatusEnum::toArray('archived') as $key => $status)
                            <option value="{{ $key }}">
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <x-system.invalid-msg field="blogPost.status"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Status -->


            <!-- Category Selector -->
            <div class="row form-group mt-5">
                <label for="blogPost-title" class="col-sm-3 col-form-label input-label">{{ translate('Category') }}</label>

                <div class="col-sm-9">
                    <x-ev.form.categories-selector
                        error-bag-name="selected_categories"
                        :items="$categories"
                        :selected-categories="$this->levelSelectedCategories()"
                        :multiple="true"
                        :required="true"
                        :search="true">
                    </x-ev.form.categories-selector>
                </div>
            </div>
            <!-- END Category Selector -->


            <!-- Subscription only -->
            <div class="row form-group">
                <label for="blogPost-subscription_only" class="col-sm-3 col-form-label input-label">{{ translate('Subscription only') }}</label>

                <div class="col-sm-9 d-flex align-items-center">
                    <!-- Checkbox Switch -->
                    <label class="toggle-switch d-flex align-items-center" for="blogPost-subscription_only">
                        <input type="checkbox" class="toggle-switch-input" id="blogPost-subscription_only" wire:model.defer="blogPost.subscription_only">
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                          </span>
                        <span class="toggle-switch-content">
                            <span class="d-block">{{ translate('Yes') }}</span>
                          </span>
                    </label>
                    <!-- End Checkbox Switch -->
                </div>

                {{-- TODO: Add Subscription multi-select element--}}
            </div>
            <!-- END Subscription only -->

            <!-- Excerpt -->
            <div class="row form-group">
                <label for="blogPost-excerpt" class="col-sm-3 col-form-label input-label">{{ translate('Excerpt') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blogPost.excerpt') is-invalid @enderror"
                                  name="blogPost.excerpt"
                                  id="blogPost-excerpt"
                                  wire:model.defer="blogPost.excerpt">
                        </textarea>
                    </div>

                    <x-system.invalid-msg field="blogPost.excerpt"></x-system.invalid-msg>
                </div>


            </div>
            <!-- END Excerpt -->

            <!-- Content -->
            <div class="row form-group">
                <label for="blogPost-content" class="col-sm-3 col-form-label input-label">{{ translate('Content') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <div class="toast-ui-editor-custom w-100">
                            <div class="js-toast-ui-editor @error('blogPost.content') is-invalid @enderror"
                                 data-ev-toastui-editor-options=""></div>

                            <input type="text"
                                   value=""
                                   data-textarea
                                   id="blogPost-content"
                                   name="blogPost.content" style="display: none !important;" wire:model.delay="blogPost.content"/>
                        </div>
                    </div>

                    <x-system.invalid-msg field="blogPost.content"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Content -->

            <hr class="my-4"/>

            <h3 class="h4"> {{ translate('SEO') }}</h3>

            <!-- Meta Title -->
            <div class="row form-group">
                <label for="blogPost-meta_title" class="col-sm-3 col-form-label input-label">{{ translate('Meta title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('blogPost.meta_title') is-invalid @enderror"
                               name="blogPost.meta_title"
                               id="blogPost-meta_title"
                               placeholder="{{ translate('Post SEO/meta title') }}"
                               wire:model.defer="blogPost.meta_title" />
                    </div>
                </div>

                <x-system.invalid-msg field="blogPost.meta_title"></x-system.invalid-msg>
            </div>
            <!-- END Meta Title -->

            <!-- Meta Description -->
            <div class="row form-group">
                <label for="blogPost-meta_description" class="col-sm-3 col-form-label input-label">{{ translate('Meta description') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blogPost.meta_description') is-invalid @enderror"
                                  name="blogPost.meta_description"
                                  id="blogPost-meta_description"
                                  placeholder="{{ translate('Post SEO/meta description') }}"
                                  wire:model.defer="blogPost.meta_description">
                        </textarea>
                    </div>
                </div>

                <x-system.invalid-msg field="blogPost.meta_description"></x-system.invalid-msg>
            </div>
            <!-- END Meta Description -->

            <!-- Meta Keywords -->
            <div class="row form-group">
                <label for="blogPost-meta_keywords" class="col-sm-3 col-form-label input-label">{{ translate('Meta keywords') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blogPost.meta_keywords') is-invalid @enderror"
                                  name="blogPost.meta_keywords"
                                  id="blogPost-meta_keywords"
                                  placeholder="{{ translate('Post SEO/meta keywords') }}"
                                  wire:model.defer="blogPost.meta_keywords">
                        </textarea>
                    </div>
                </div>

                <x-system.invalid-msg field="blogPost.meta_keywords"></x-system.invalid-msg>
            </div>
            <!-- END Meta Keywords -->

            <!-- Meta Img -->
            <div class="row form-group">
                <div class="col-sm-3 col-form-label input-label">{{ translate('Meta image') }}</div>

                <div class="col-sm-9 d-flex flex-column justify-content-center align-items-start">
                    <label class="card-img-top pointer border rounded p-1 mb-0 mt-0" for="avatarUploader"
                           style="width: 180px; height: 115px;"
                           x-data="{
                                name: 'blogPost.meta_img',
                                imageID: {{ $blogPost->meta_img?->id ?? 'null' }},
                                imageURL: '{{ $blogPost->getUpload('meta_img', ['w'=>220]) }}',
                            }"
                           @aiz-selected.window="
                             if(event.detail.name === name) {
                                imageURL = event.detail.imageURL;
                                $wire.set('blogPost.meta_img', $('input[name=\'blogPost.meta_img\']').val(), true);
                             }"
                           data-toggle="aizuploader"
                           data-type="image">
                        <img id="avatarImg" class="avatar-img rounded w-100" x-bind:src="imageURL" >

                        <input type="hidden" x-bind:name="name" wire:model.defer="blogPost.meta_img" class="selected-files" data-preview-width="200">
                    </label>

                    <x-system.invalid-msg class="mt-1" field="blogPost.meta_img"></x-system.invalid-msg>
                </div>
            </div>
            <!-- End Meta Img -->

            <hr/>
            <div class="row form-group mb-0">
                <div class="col-12 d-flex">
                    {{-- TODO: Standardize Categories selection for various Content Types --}}
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="
                            $wire.set('blogPost.content', $('#blogPost-content').val(), true);
                            $wire.set('blogPost.status', $('#blog-post-status-selector').val(), true);
                            let $selected_categories = [];
                            $('[name=\'selected_categories\']').each(function(index, item) {
                                $selected_categories = [...$selected_categories, ...$(item).val()];
                            });
                            $wire.set('selected_categories', $selected_categories, true);
                            $wire.saveBlogPost();">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
