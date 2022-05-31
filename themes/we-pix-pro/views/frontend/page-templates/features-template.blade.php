{{-- NOT BEING USED BY PAGE...Features page is using features-grid-01 component along with buttong-group component from WeBuilder deprecated way of building pages --}}
@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Pix-pro Features'),
    'header_subtitle' => null,
])

{{-- Features table --}}
<div class="bg-gradient-to-b from-white to-[#EFF0F4] py-16 sm:py-24 lg:py-32">
    <div class="relative mx-auto max-w-full px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">

        @php
            $items = [
                [
                    'title' => translate('Highly Detailed 3D Terrains'),
                    'text' => translate('The object visualization in a 3D mode has never been so easy – no matter the size of the object, enjoy the navigation through different dimensions without losing even the smallest detail.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038771_3d-terrain-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Highly Detailed 3D Terrains'),
                    ]
                ],
                [
                    'title' => translate('Photo Manager'),
                    'text' => translate('Wide range of photo management options enables the user to process the photos acquired by any camera. With Photo Manager you can easily inspect, remove or add the photos for further data processing.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038771_photo-manager-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Photo Manager'),
                    ]
                ],
                [
                    'title' => translate('Advanced Data Export'),
                    'text' => translate('PixPro supports quite a few export formats for dense point clouds, elevation maps and meshes. During the export down-sampling and various coordinate systems can be selected for maximum compatibility with other solutions.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038769_data-export-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Advanced Data Export'),
                    ]
                ],
                [
                    'title' => translate('Interactive DEM Histogram'),
                    'text' => translate('Digital Elevation Maps can be shaded with different colors and different color ramps to adapt each option to the scanned surface. Any surface can be represented accurately in PixPro.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038770_DEM-histogram-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Interactive DEM Histogram'),
                    ]
                ],
                [
                    'title' => translate('DEM Surface Editing Tools'),
                    'text' => translate('Digital Elevation Map can be edited for cleanup or simulation purposes. Terrain features can be leveled, missing surfaces can be filled and modified. Unlimited and non-destructive editing is quick and easy in PixPro.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007632_DEM-editing-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('DEM Surface Editing Tools'),
                    ]
                ],
                [
                    'title' => translate('Contour-line Generation'),
                    'text' => translate('Contour-line map can be generated for any DEM surface. Contour-lines can have custom height values and can be offset while being represented in 3D.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007633_contourlines-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Contour-line Generation'),
                    ]
                ],
                [
                    'title' => translate('Single Contour-line Drawing'),
                    'text' => translate('In PixPro a single contour-line can be drawn by the user. Contour-line can just be placed with real time preview on the entire project area. It can be converted to a polygon as well.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007632_single-contour-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Single Contour-line Drawing'),
                    ]
                ],
                [
                    'title' => translate('2D Measurements'),
                    'text' => translate('Obtain all possible 2 dimensional measurements quickly and easily. Dense point cloud, elevation map and mesh can be measured.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007633_2d-measurements-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('2D Measurements'),
                    ]
                ],
                [
                    'title' => translate('3D Measurements'),
                    'text' => translate('Obtain all possible 3 dimensional measurements quickly and easily. Volumetric measurements are done on the digital elevation map in real time.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007632_3d-measurements-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('3D Measurements'),
                    ]
                ],
                [
                    'title' => translate('Profile Measurements'),
                    'text' => translate('Use any line object to view a terrain profile. The profile itself is interactive and can be measured.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007900_profile-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Profile Measurements'),
                    ]
                ],
                [
                    'title' => translate('Direct Sight Functions'),
                    'text' => translate('PixPro’s direct sight functions help to evaluate 3D scene features that will result in obscured sight zones from a particular point of view. Perfect for security and safety applications.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007900_direct-sight-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Direct Sight Functions'),
                    ]
                ],
                [
                    'title' => translate('Dense Point Cloud'),
                    'text' => translate('Dense point cloud - the key element in creating a 3D environment from the original 2D photos. In PixPro various density point clouds can be created, to achieve desired processing times and results.'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007900_dense-cloud-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Dense Point Cloud'),
                    ]
                ],
                [
                    'title' => translate('Digital Elevation Map'),
                    'text' => translate('Digital elevation map provides terrain information as a height map. DEM layer is useful for quick and unlimited visualization of the scanned surface. Many shading options as well as cropping and hole-filling options enable you…'),
                    'image' => [
                        'file_name' => 'uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650007900_digital-elevation-map-500x281.jpg',
                        'options' => ['w' => 350],
                        'alt_text' => translate('Digital Elevation Map'),
                    ]
                ],
            ];
        @endphp
        <div class="grid gap-8 grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 ">
            @foreach($items as $item_data)
                @include('frontend.partials.pix-feature-card', ['data' => $item_data])
            @endforeach
        </div>



      {{-- ITT Group --}}
      {{-- <div we-slot name="itt_group_slot" we-title="Features" class="w-full">
        <x-ev.image-title-text-group
            we-name="itts"
            we-title="Features"
            class="grid gap-8 grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 "
            :per_row="$weData['itt_group_slot']['components']['itts']['data']['per_row'] ?? []"
            :itt-group="$weData['itt_group_slot']['components']['itts']['data']['itt_group'] ?? []">

            Add component content here instead of the image-title-text-group.blade and use $component->{property} to get the properties
            @if(!empty($component->ittGroup))
              @foreach($component->ittGroup as $itt)
                <div class="{{ $itt['class'] ?? '' }}">
                  @if(!empty($itt['href'] ?? null))
                    <a class="block w-full" href="{{ $itt['href'] }}" target="{{ $itt['target'] ?? '_self' }}">
                  @endif

                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                      @if(!empty($itt['image'] ?? null))
                        <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="{{ IMG::get($itt['image']['file_name'], IMG::mergeWithDefaultOptions($itt['options'] ?? [], 'original')) }}" alt="{{ $itt['image_alt_text'] ?? '' }}"
                                class="w-full object-cover" />
                        </div>
                      @endif

                      <div class="w-full text-left px-6">
                        @if(!empty($itt['title'] ?? null) && !empty($itt['title_tag'] ?? null))
                          <{{ $itt['title_tag'] }} class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            {{ $itt['title'] }}
                          </{{ $itt['title_tag'] }}>
                        @endif

                        @if(!empty($itt['text'] ?? null))
                          <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            {{ $itt['text'] }}
                          </p>
                        @endif
                      </div>
                    </div>
                  </div>

                  @if(!empty($itt['href'] ?? null))
                    </a>
                  @endif
                </div>
              @endforeach
            @endif

        </x-ev.image-title-text-group>
      </div> --}}

      {{-- Buttons --}}
      {{-- <div we-slot name="button_group_slot" we-title="Buttons" class="w-full mt-[40px]">
        <x-ev.link-button-group
            we-name="buttons"
            we-title="Buttons"
            class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}""
            class="w-full flex justify-center"
            :button-group="$weData['button_group_slot']['components']['buttons']['data']['button_group'] ?? []">
        </x-ev.link-button-group>
      </div> --}}

    </div>
  </div>


<section class="w-full bg-gradient-to-b from-white to-[#EFF0F4] lg:pt-[80px]  lg:pb-[80px]  sm:pt-[50px]  sm:pb-[50px]  pt-[40px]  pb-[40px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full">
            {{-- <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8"> --}}
            <div class="relative">
                <h2 class="sr-only">Contact us</h2>

                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <!-- Contact form -->
                    <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
                        <h3 class="text-18 font-bold text-gray-900">{{ translate('Have Questions? Reach Out To Us') }}</h3>
                        <livewire:forms.contact-form />
                    </div>

                    <!-- Contact information -->
                    <div class="relative overflow-hidden py-10 px-6  sm:px-10 xl:p-12">
                        <h3 class="text-[20px] font-bold text-typ-1">{{ translate('Technical & Support Center') }}</h3>
                        <p class="mt-3 sm:mt-6 text-14 text-typ-2 max-w-3xl">
                            {{ translate('Contact us and we will reach out to you in 1 working day.') }}
                        </p>
                        <div class="flex flex-col space-y-1 text-14 py-6 text-typ-2">
                            <span>{{ translate('Aušros al. 39,') }}</span>
                            <span>{{ translate('LT-76300') }}</span>
                            <span>{{ translate('Šiauliai, Lithuania') }}</span>
                        </div>
                        <dl class="mt-2 space-y-3">
                            <dt><span class="sr-only">{{ translate('Phone number') }}</span></dt>
                            <dd class="flex text-base text-typ-3">
                                @svg('heroicon-o-phone', ['class' => 'flex-shrink-0 w-6 h-6 text-primary'])
                                <span class="ml-3">{{ translate('+1 (555) 123-4567') }}</span>
                            </dd>
                            <dt><span class="sr-only">{{ translate('Email') }}</span></dt>
                            <dd class="flex text-base text-typ-3">
                                @svg('heroicon-o-mail', ['class' => 'flex-shrink-0 w-6 h-6 text-primary'])
                                <span class="ml-3">{{ translate('support@example.com') }}</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
</section>

@include('components.custom.full-width-cta')
