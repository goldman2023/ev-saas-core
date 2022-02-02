<div x-data="{
    blog_post: @entangle('blog_post').defer,
}"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>
    <div class="col-lg-12 position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="saveBlogPost"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <div class=""
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="saveBlogPost"
        >

            <!-- Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper"
                     x-data="{
                        name: 'blog_post.cover',
                        imageID: {{ $blog_post->cover->id ?? 'null' }},
                        imageURL: '{{ $blog_post->getCover(['w'=>1200]) }}',
                    }"
                     @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('blog_post.cover', $('input[name=\'blog_post.cover\']').val(), true);
                     }"
                     data-toggle="aizuploader"
                     data-type="image">

                    <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">

                    <!-- Custom File Cover -->
                    <div class="profile-cover-content profile-cover-btn custom-file-manager"
                         data-toggle="aizuploader" data-type="image">
                        <div class="custom-file-btn">
                            <input type="hidden" x-bind:name="name" wire:model.defer="blog_post.cover" class="selected-files" data-preview-width="1200">

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
                        name: 'blog_post.thumbnail',
                        imageID: {{ $blog_post->thumbnail->id ?? 'null' }},
                        imageURL: '{{ $blog_post->getThumbnail() }}',
                    }"
                   @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('blog_post.thumbnail', $('input[name=\'blog_post.thumbnail\']').val(), true);
                     }"
                   data-toggle="aizuploader"
                   data-type="image">
                <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                <input type="hidden" x-bind:name="name" wire:model.defer="blog_post.thumbnail" class="selected-files" data-preview-width="200">

                <span class="avatar-uploader-trigger">
                  <i class="avatar-uploader-icon shadow-soft">
                      @svg('heroicon-o-pencil', ['class' => 'square-16'])
                  </i>
                </span>
            </label>
            <!-- End Thumbnail -->

            <x-default.system.invalid-msg field="blog_post.thumbnail"></x-default.system.invalid-msg>

            <x-default.system.invalid-msg field="blog_post.cover"></x-default.system.invalid-msg>

            <!-- Title -->
            <div class="row form-group mt-5" x-data="{
                url_template: '{{ route('shop.blog.post.index', ['%shop_slug%', '%slug%'], false) }}',
                url: '',
                generateURL($slug) {
                    this.url = this.url_template.replace('%shop_slug%', '{{ MyShop::getShop()->slug ?? '' }}').replace('%slug%', '<strong>'+$slug.slugify()+'</strong>');
                }
            }">
                <label for="blog_post-title" class="col-sm-3 col-form-label input-label">{{ translate('Title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('blog_post.title') is-invalid @enderror"
                               name="blog_post.title"
                               id="blog_post-title"
                               placeholder="{{ translate('New post title') }}"
                               @input="generateURL($($el).val())"
                               wire:model.defer="blog_post.title" />
                    </div>

                    <div class="w-100 d-flex align-items-center mt-2">
                        <strong class="mr-2">{{ translate('URL') }}:</strong>
                        <span x-html="url"></span>
                    </div>

                    <x-default.system.invalid-msg field="blog_post.title"></x-default.system.invalid-msg>
                </div>
            </div>
            <!-- END Title -->


            <!-- Category Selector -->
            
            <!-- END Category Selector -->

            <!-- Subscription only -->
            <div class="row form-group">
                <label for="blog_post-subscription_only" class="col-sm-3 col-form-label input-label">{{ translate('Subscription only') }}</label>

                <div class="col-sm-9 d-flex align-items-center">
                    <!-- Checkbox Switch -->
                    <label class="toggle-switch d-flex align-items-center" for="blog_post-subscription_only">
                        <input type="checkbox" class="toggle-switch-input" id="blog_post-subscription_only" wire:model.defer="blog_post.subscription_only">
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
                <label for="blog_post-excerpt" class="col-sm-3 col-form-label input-label">{{ translate('Excerpt') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blog_post.excerpt') is-invalid @enderror"
                                  name="blog_post.excerpt"
                                  id="blog_post-excerpt"
                                  wire:model.defer="blog_post.excerpt">
                        </textarea>
                    </div>

                    <x-default.system.invalid-msg field="blog_post.excerpt"></x-default.system.invalid-msg>
                </div>


            </div>
            <!-- END Excerpt -->

            <!-- Content -->
            <div class="row form-group">
                <label for="blog_post-content" class="col-sm-3 col-form-label input-label">{{ translate('Content') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <div class="toast-ui-editor-custom w-100">
                            <div class="js-toast-ui-editor @error('blog_post.content') is-invalid @enderror"
                                 data-ev-toastui-editor-options=""></div>

                            <input type="text"
                                   value=""
                                   data-textarea
                                   id="blog_post-content"
                                   name="blog_post.content" style="display: none !important;" wire:model.delay="blog_post.content"/>
                        </div>
                    </div>

                    <x-default.system.invalid-msg field="blog_post.content"></x-default.system.invalid-msg>
                </div>
            </div>
            <!-- END Content -->

            <hr class="my-4"/>

            <h3 class="h4"> {{ translate('SEO') }}</h3>

            <!-- Meta Title -->
            <div class="row form-group">
                <label for="blog_post-meta_title" class="col-sm-3 col-form-label input-label">{{ translate('Meta title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('blog_post.meta_title') is-invalid @enderror"
                               name="blog_post.meta_title"
                               id="blog_post-meta_title"
                               placeholder="{{ translate('Post SEO/meta title') }}"
                               wire:model.defer="blog_post.meta_title" />
                    </div>
                </div>

                <x-default.system.invalid-msg field="blog_post.meta_title"></x-default.system.invalid-msg>
            </div>
            <!-- END Meta Title -->

            <!-- Meta Description -->
            <div class="row form-group">
                <label for="blog_post-meta_description" class="col-sm-3 col-form-label input-label">{{ translate('Meta description') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blog_post.meta_description') is-invalid @enderror"
                                  name="blog_post.meta_description"
                                  id="blog_post-meta_description"
                                  placeholder="{{ translate('Post SEO/meta description') }}"
                                  wire:model.defer="blog_post.meta_description">
                        </textarea>
                    </div>
                </div>

                <x-default.system.invalid-msg field="blog_post.meta_description"></x-default.system.invalid-msg>
            </div>
            <!-- END Meta Description -->

            <!-- Meta Keywords -->
            <div class="row form-group">
                <label for="blog_post-meta_keywords" class="col-sm-3 col-form-label input-label">{{ translate('Meta keywords') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('blog_post.meta_keywords') is-invalid @enderror"
                                  name="blog_post.meta_keywords"
                                  id="blog_post-meta_keywords"
                                  placeholder="{{ translate('Post SEO/meta keywords') }}"
                                  wire:model.defer="blog_post.meta_keywords">
                        </textarea>
                    </div>
                </div>

                <x-default.system.invalid-msg field="blog_post.meta_keywords"></x-default.system.invalid-msg>
            </div>
            <!-- END Meta Keywords -->

            <!-- Meta Img -->
            <div class="row form-group">
                <div class="col-sm-3 col-form-label input-label">{{ translate('Meta image') }}</div>

                <div class="col-sm-9 d-flex flex-column justify-content-center align-items-start">
                    <label class="card-img-top pointer border rounded p-1 mb-0 mt-0" for="avatarUploader"
                           style="width: 180px; height: 115px;"
                           x-data="{
                                name: 'blog_post.meta_img',
                                imageID: {{ $blog_post->meta_img?->id ?? 'null' }},
                                imageURL: '{{ $blog_post->getUpload('meta_img', ['w'=>220]) }}',
                            }"
                           @aiz-selected.window="
                             if(event.detail.name === name) {
                                imageURL = event.detail.imageURL;
                                $wire.set('blog_post.meta_img', $('input[name=\'blog_post.meta_img\']').val(), true);
                             }"
                           data-toggle="aizuploader"
                           data-type="image">
                        <img id="avatarImg" class="avatar-img rounded w-100" x-bind:src="imageURL" >

                        <input type="hidden" x-bind:name="name" wire:model.defer="blog_post.meta_img" class="selected-files" data-preview-width="200">
                    </label>

                    <x-default.system.invalid-msg class="mt-1" field="blog_post.meta_img"></x-default.system.invalid-msg>
                </div>
            </div>
            <!-- End Meta Img -->

            <hr/>
            <div class="row form-group mb-0">
                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="$wire.set('blog_post.content', $('#blog_post-content').val(), true); $wire.saveBlogPost();">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
