{{-- NOT BEING USED BY PAGE...Features page is using features-grid-01 component along with buttong-group component from WeBuilder deprecated way of building pages --}}
@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Pixpro Features'),
    'header_subtitle' => null,
])

{{-- Features table --}}
<div class="relative bg-white py-16 sm:py-24 lg:py-32  lg:pt-[80px]  lg:pb-[80px]  sm:pt-[60px]  sm:pb-[60px]  pt-[40px]  pb-[40px]   bg-[#fff]   ">

    <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
  
      
      <div we-slot="" name="itt_group_slot" we-title="Features" class="w-full">
        <div class="grid gap-8 grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 grid gap-8 grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 " x-data="{}">
      <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038771_3d-terrain-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Highly Detailed 3D Terrains
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            The object visualization in a 3D mode has never been so easy – no matter the size of the object, enjoy the navigation through different dimensions without losing even the smallest detail.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1650038771_photo-manager-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Photo Manager
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Wide range of photo management options enables the user to process the photos acquired by any camera. With Photo Manager you can easily inspect, remove or add the photos for further data processing.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650006933_data-export-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Advanced Data Export
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            PixPro supports quite a few export formats for dense point clouds, elevation maps and meshes. During the export down-sampling and various coordinate systems can be selected for maximum compatibility with other solutions.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007632_DEM-histogram-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Interactive DEM Histogram
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Digital Elevation Maps can be shaded with different colors and different color ramps to adapt each option to the scanned surface. Any surface can be represented accurately in PixPro.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007632_DEM-editing-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            DEM Surface Editing Tools
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Digital Elevation Map can be edited for cleanup or simulation purposes. Terrain features can be leveled, missing surfaces can be filled and modified. Unlimited and non-destructive editing is quick and easy in PixPro.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007633_contourlines-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Contour-line Generation
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Contour-line map can be generated for any DEM surface. Contour-lines can have custom height values and can be offset while being represented in 3D.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007632_single-contour-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Single Contour-line Drawing
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                                                    Obtain all possible 2 dimensional measurements quickly and easily. Dense point cloud, elevation map and mesh can be measured.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007633_2d-measurements-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            2D Measurements
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            In PixPro a single contour-line can be drawn by the user. Contour-line can just be placed with real time preview on the entire project area. It can be converted to a polygon as well.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007632_3d-measurements-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            3D Measurements
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Obtain all possible 3 dimensional measurements quickly and easily. Volumetric measurements are done on the digital elevation map in real time.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007900_profile-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Profile Measurements
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Use any line object to view a terrain profile. The profile itself is interactive and can be measured.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007900_direct-sight-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Direct Sight Functions
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            PixPro’s direct sight functions help to evaluate 3D scene features that will result in obscured sight zones from a particular point of view. Perfect for security and safety applications.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007900_dense-cloud-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Dense Point Cloud
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Dense point cloud - the key element in creating a 3D environment from the original 2D photos. In PixPro various density point clouds can be created, to achieve desired processing times and results.
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
                            <div class="">
                  
                  <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
                    <div class="w-full">
                                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                          <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1650007900_digital-elevation-map-500x281.jpg@webp" alt="" class="w-full object-cover">
                        </div>
                      
                      <div class="w-full text-left px-6">
                                                <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                            Digital Elevation Map
                          </h3>
                        
                                                <p class="mt-3 text-base text-gray-500 line-clamp-5">
                            Digital elevation map provides terrain information as a height map. DEM layer is useful for quick and unlimited visualization of the scanned surface. Many shading options as well as cropping and hole-filling options enable you…
                          </p>
                                            </div>
                    </div>
                  </div>
  
                                </div>
  </div>    </div>
  
      
      <div we-slot="" name="button_group_slot" we-title="Buttons" class="w-full mt-[40px]">
        <div class="w-full flex justify-center">
                          <div class="rounded-md shadow ">
                  <a href="/page/pixpro-detailed-features-list" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10 " target="_self"> 
                      Detailed features list
                  </a>
              </div>
              </div>    </div>
  
    </div>
  </div>

@include('components.custom.full-width-cta')
