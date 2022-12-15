@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Detailed Features List'),
    'header_subtitle' => null,
])

<section class="w-full bg-gradient-to-b from-white to-[#EFF0F4]">
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Input') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:grid-rows-2 sm:grid-flow-col sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('JPEG Images') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Any size and compression') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('EXIF metadata detection') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Detects sensor, lens, GPS data automatically.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('RTK imagery support') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">For accurate georeferencing results.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Flight track support') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">For separate image geotagging.</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Processing --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Processing') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Photo set manager') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('For reviewing, deleting photos before the reconstruction begins.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Workspace area selection') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">For selecting a part for processing from the whole image set.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Calibration database for faster reconstruction') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">For better reconstruction results for known cameras and lenses.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Calibration optimization option') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">For more difficult reconstruction examples and unknown cameras.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Manual calibration data input') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">For advanced users to enter calibration data.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Full workflow presets') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">One click to process all layers. Optimal presets can be saved by the user.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Dense point cloud') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">High, medium or low density.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('3D Mesh') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">3D model from dense point cloud.</dd>
            </div>

            <div class="relative">
                <dt>
                    <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Texture') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Realistic texture for 3D mesh.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Digital elevation map') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Selectable GSD, smoothing and hole filling options.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Orthophoto') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Selectable GSD, color correction option.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Contour lines') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Selectable interval and offset values.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Project summary') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Automatically generated report with processing details.</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Objects --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Objects') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Points, Lines, Polygons') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Objects can be precisely drawn on images using projections. All objects show their measurements instantly. Objects can be snapped to each other or imported as .shp or .pxg files.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Single contour line') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Real-time single contour line placing tool. Closed single contours can be converted to polygons.') }}</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Measurements --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Measurements') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('2D Horizontal length') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Line length as seen from above.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('2D Area') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Polygon area as seen from above.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('2D Height') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Height difference between points in line.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Sight-line length') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">The shortest length between 3D points.</dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Surface length') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Draped-on-surface line length.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('3D Area') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Surface area of a polygon.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('3D Volume') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Polygon volume calculation with 6 different plane options.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Slope angle') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Degrees of angle between points.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Timeline') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Tool for comparing volumes in time. Any amount of DEMs can be compared using the same polygon and base plane.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Elevation') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Height difference between first and last points in line.</dd>
            </div>
          </dl>
        </div>
    </div>


    {{-- DEM tools --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('DEM tools') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Profile') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Terrain profile visualization and measurements. Available for every line and polygon also.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Level by Averaging') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Levels out the terrain by averaging height values of the selection points.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('2D Height') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Height difference between points in line.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Level by Maximum') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Levels out the terrain by the maximum selection point height.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Level by Minimum') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Levels out the terrain by the minimum selection point height.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Level by Offset') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Offsets the terrain by a set amount while keeping the terrain features.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Cut hole') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Cuts a hole in the DEM.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Crop') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Crops entire DEM to selection.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Fill') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Fills a hole in the DEM.</dd>
            </div>

          </dl>
        </div>
    </div>

    {{-- GEOReferencing --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Georeferencing') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Ground control point manager') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('For creating, importing, deleting and adjusting projections of ground control points before georeferencing.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Georeference to Photo locations') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Georeferences the point cloud to photo GPS data.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Georeference to Ground Control Points') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Georeferences the point cloud to GCPs.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Adjustment to Ground Control points') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Adjust the point cloud to a single or couple GCPs if no more are available.</dd>
            </div>

            <div class="relative">
                <dt>

                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Set scaling') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">Project scaling for accurate scale representation.</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- View options --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('View options') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Viewports') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Viewports can be stored and loaded for quick navigation.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Isometric and Perspective projections') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Different projections for convenient drawing and accurate visualization.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Predefined views') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Standard views for quick navigation.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('View history on map') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Project history displayed as pinned locations on map.</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Import/Export --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Import/Export') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Dense point cloud export') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Export georeferenced point clouds in .las .xyz .ply file formats.') }}</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('3D Mesh export') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Export 3D mesh with textures in .obj and .ply file formats.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('DEM/Orthophoto export') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Export DEM to .obj .tif and Orthophoto to .tif file formats.</dd>
            </div>

            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Object export') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">Export drawn objects to .shp .dxf .pxg file formats.</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Operating System --}}
    <div class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Operating System') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>

                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Microsoft Windows') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">{{ translate('Windows 7, 8, 10, Server 2008, Server 2012, 64 bits.') }}</dd>
            </div>
          </dl>
        </div>
    </div>

    {{-- Hardware and software requirements --}}
    <div
    id="hardware-requriements"
    class="max-w-7xl mx-auto py-16 pb-10 px-4 sm:px-6 lg:pt-12 lg:pb-12 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8 border-b border-gray-200">
        <div>
          {{-- <h2 class="text-base font-semibold text-primary uppercase tracking-wide">Everything you need</h2> --}}
          <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ translate('Hardware and software requirements') }}</p>
          {{-- <p class="mt-4 text-lg text-gray-500">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec.</p> --}}
        </div>
        <div class="mt-12 lg:mt-0 lg:col-span-2">
          <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-1  sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <div class="relative">
              <dt>
                <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Minimum requirements') }}</p>
              </dt>
              <dd class="mt-2 ml-9 text-base text-gray-500">
                Windows 7, 8, 10, Server 2008, Server 2012,64 bits. Any CPU.<br/>
                Integrated graphic card Intel HD 4000 and above.<br/>
                Projects < 500 photos: 16 GB RAM, 20 GB HDD Free space.<br/>
                Projects > 500 photos: 32 GB RAM, 40 GB HDD Free space.<br/>
              </dd>
            </div>

            <div class="relative">
                <dt>
                  <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ translate('Recommended  requirements') }}</p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">
                    Windows 10, Server 2008, Server 2012, 64 bits. Any CPU (8 or more threads).<br/>
                    Integrated graphic card Intel HD 4000 and above. Hard disk: SSD.<br/>
                    Dedicated graphics card with CUDA 3.0 or OpenCL 1.2 compatibility.<br/>
                    Projects < 500 photos: 16 GB RAM, 40 GB SSD Free space.<br/>
                    Projects > 500 photos: 32 GB RAM, 60 GB SSD Free space.<br/>
                </dd>
              </div>
          </dl>
        </div>
    </div>
</section>
