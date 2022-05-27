@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Support Channels'),
    'header_subtitle' => null,
])


<section class="relative py-[50px] md:py-[80px]"  x-data="{
    tab: 'channels',
    initPage() {
      const url = new URL(window.location.href);
      let current_tab = url.searchParams.get('tab');

      $watch('tab', (value) => {
          const url = new URL(window.location.href);
          url.searchParams.set('tab', value);
          history.pushState(null, document.title, url.toString());
      });

      if(['channels','videos','faq'].includes(current_tab)) {
        this.tab = current_tab;
      }
    }
}" x-init="initPage();">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
        <div x-cloak class="relative self-center bg-gray-100 rounded-lg p-0.5 flex flex-col sm:flex-row justify-center items-center ">
            <button type="button" @click="tab = 'channels'" :class="{'bg-primary text-white':tab == 'channels', 'gray-900':tab == 'channels'}" class="min-w-[180px] relative w-full border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8 bg-primary text-white gray-900">Support Channel</button>
            <button type="button" @click="tab = 'videos'" :class="{'bg-primary text-white':tab == 'videos', 'gray-900':tab == 'videos'}" class="min-w-[180px] ml-0.5 relative w-full border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">Videos</button>
            <button type="button" @click="tab = 'faq'" :class="{'bg-primary text-white':tab == 'faq', 'gray-900':tab == 'faq'}" class="min-w-[180px] ml-0.5 relative w-full border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">FAQ</button>
        </div>
    </div>

    <iframe id="video_iframe_template" class="hidden w-full h-[200px] md:h-[300px] mb-6" src="" ></iframe>

    <div class="w-full" x-cloak>
      <div class="w-full" x-show="tab == 'channels'">
        <p class=" text-gray-700 text-16 sm:text-20 text-center mb-10">
          Detailed Pixpro guide and other useful bits of information can be found <a href="https://help.pix-pro.com/" class="text-primary" target="_blank">HERE</a>. And if you ever find yourself in need of a support, contact us via platform of your choice:
        </p>

        <div class="grid grid-cols-12 gap-8">
            <a href="https://discord.com/invite/XBhmAxzXnp" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://seeklogo.com/images/D/discord-color-logo-E5E6DFEF80-seeklogo.com.png" class="w-[65px] h-[65px] object-contain mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Join our Discord support server</h4>
                <p class=" text-14 text-gray-700 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
            </a>
            <a href="https://www.facebook.com/groups/pixprosupport" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="w-[65px] h-[65px] mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Join our Facebook support group</h4>
                <p class=" text-14 text-gray-700 leading-6">Facebook is your platform of choice? Seek for help by joining our Facebook support group.</p>
            </a>
            <a href="/page/contact" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://e7.pngegg.com/pngimages/402/714/png-clipart-email-logo-email-computer-icons-signature-block-mail-miscellaneous-trademark.png" class="w-[65px] h-[65px] mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Contact us directly via email</h4>
                <p class=" text-14 text-gray-700 leading-6">Prefer writing an email?</p>
            </a>
        </div>
      </div>
      <div class="w-full" x-show="tab == 'videos'" >
        <div class="grid grid-cols-12 gap-6" x-data="{
          replaceVideo($el, video_src) {
            let iframe = document.getElementById('video_iframe_template');
            iframe = iframe.cloneNode(true);
            iframe.setAttribute('src', this.video_src);
            iframe.classList.remove('hidden');

            $el.innerHTML = '';
            $el.appendChild(iframe);
          }
        }">
          <div class="col-span-12 md:col-span-6 flex flex-col" @click="replaceVideo($el.querySelector('.iframe-wrapper'), video_src)" x-data="{video_src: 'https://www.youtube.com/embed/8rXemRWyKMM'}">
            <div class="iframe-wrapper h-[200px] md:h-[300px] mb-6">
              <img src="https://i.ytimg.com/vi/8rXemRWyKMM/hqdefault.jpg" class="w-full h-full object-cover cursor-pointer rounded-lg border border-gray-200" />
            </div>
            <strong class="text-24">{{ translate('Local processing – Getting started') }}</strong>
          </div>
          <div class="col-span-12 md:col-span-6 flex flex-col" @click="replaceVideo($el.querySelector('.iframe-wrapper'), video_src)" x-data="{video_src: 'https://www.youtube.com/embed/dPqoldgyT2M'}">
            <div class="iframe-wrapper h-[200px] md:h-[300px] mb-6">
              <img src="https://i.ytimg.com/vi/8rXemRWyKMM/hqdefault.jpg" class="w-full h-full object-cover cursor-pointer rounded-lg border border-gray-200" />
            </div>
            <strong class="text-24">{{ translate('Cloud processing – Getting started ') }}</strong>
          </div>
        </div>
    </div>
      <div class="w-full" x-show="tab == 'faq'" x-cloak>
        <div class="w-full">
          <section class="py-10 2xl:py-40">
            <div class="container px-4 mx-auto">
              <div class="text-center">
                <h2 class="text-28 font-bold font-heading">Pre-run and requirements</h2>
              </div>
            </div>
            <div class="max-w-4xl mx-auto pt-5 border-t border-gray-50">
              <ul>
                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">1</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">How do I install the software?</h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <ol class="list-decimal space-y-1"><li>Open the installer executable, or double-click on the shortcut to it.</li><li>If you are asked about it, allow changes to be made to your computer.</li><li>Pixpro setup will pop up. Read the instructions, then proceed to next step by clicking<em> Next</em>.</li><li>In order to proceed,&nbsp;click I <em>Agree.</em></li><li>Specify the directory where the program and its files will be stored.</li><li>Please, wait until the installation procedure is completed. The green progress bar represents the process. A shortcut will be created on your desktop that will launch the application.</li><li>Click <em>Finish</em> to complete the&nbsp;installation. If you leave<em> Run Pixpro </em>checked, the application will start automatically.</li></ol>
                  </div>
                </li>
                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                  show: false
                }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">2</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('What are the minimum hardware requirements?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <p class="mb-4">Local processing:</p>
                    <p>Windows 7, 8, 10, Server 2008, Server 2012, 64 bits. Any CPU.
                      <br>Integrated graphic card Intel HD 4000 and above.
                      <br>
                      <strong>Projects &lt;500 photos:&nbsp;</strong>
                      16 GB RAM, 20 GB HDD Free space.<br>
                      <strong>Projects &gt;500 photos:&nbsp;</strong>
                      32&nbsp;GB RAM, 40 GB HDD Free space.
                    </p>
                  </div>
                </li>

                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">3</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('What are the recommended hardware requirements?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <p class="mb-4">Local processing:</p>
                    <p>Windows 10, Server 2008, Server 2012, 64 bits. Any CPU (8 or more threads).<br>
                      Dedicated graphics card with CUDA 3.0 or OpenCL 1.2 compatibility with 4 GB or more of V-ram.<br>
                      <br>
                      <br>
                      <strong>Projects &lt;500 photos: </strong>
                        16 GB RAM, 40 GB SSD Free space.<br>
                      <strong>Projects &gt;500 photos:&nbsp;</strong>
                      32 GB RAM, 60 GB SSD Free space.
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </section>

          {{-- Capturing photos for photogrammetry --}}
          <section class="py-10 2xl:py-40">
            <div class="container px-4 mx-auto">
              <div class="text-center">
                <h2 class="text-28 font-bold font-heading">{{ translate('Capturing photos for photogrammetry') }}</h2>
              </div>
            </div>
            <div class="max-w-4xl mx-auto pt-5 border-t border-gray-50">
              <ul>
                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">1</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{ translate('What kind of photos are used for photogrammetry purposes?') }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <p class="mb-4">Technically photos for photogrammetric purposes can be captured with any camera. But some things do work better than others. Photogrammetric algorithms work best with generally high-quality imagery. High quality photos can be obtained from many types of imaging devices as longs the technique and specifications are up to the job.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p class="mb-4">A few key specifications regarding the equipment are recommended:</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:list {"ordered":true} -->
                      <ol class="list-decimal space-y-2"><li><strong>Resolution:</strong> 12 megapixels is a good starting point. Any less than that introduces a little risk that not enough detail could be captured for good 3D reconstruction results.</li><li><strong>Lens focal length:</strong> anything between 16 and 135 millimeters of 35 mm equivalency should be good for photogrammetry, sweet spot being 24 - 50 mm equivalent lenses. All manufacturers specify the equivalent lens focal length because it’s the most common unit to determine how wide or zoomed-in the lens is. Always refer to the cameras or lens' manual to find the equivalent focal length. Anything wider (less) than 16 millimeters is ultra-wide angle which might introduce heavy distortion that might compromise reconstruction results. Anything longer or more 'tele' than 135 millimeters can result in shallow depth of field which also can make 3D reconstruction impossible. Specialty lenses such as fish-eye, tilt-shift, soft-focus should be generally avoided. Although macro lenses are usually well suited for photogrammetry due to their excellent optical properties.</li><li><strong>GPS geotagging:</strong> GPS data embedded in the photo helps to create projects with scale and position which is required if any measurements are to be made. This is most applicable to drones. Almost all drones embed GPS data because having a GPS sensor is an essential part of their operation. Some handheld cameras and most smartphones have GPS as well.</li></ol>
                      <!-- /wp:list --></div>
                    </div>
                </li>
                
                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">2</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('How to manage the focus of the camera?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <p class="mb-4">Some drones do have cameras which have fixed focus lenses which makes this a non-issue, but those cameras that do have adjustable focus must be used with care. The rule of thumb is to always use manual focus. Set the focus on the scanned object or terrain and then turn the manual focus mode on, so that the focus will not change between images.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p>If the distance between the object or terrain and the camera is extremely variable, first the flight plan should be adjusted and if that is not possible autofocus can be used.</p>
                      <!-- /wp:paragraph --></div>
                    </div>
                </li>

                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">3</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('How to deal with motion blur in photos?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <p class="mb-4">This is primarily applicable to drone imaging, because the drone is moving while taking photos. To avoid motion blur the camera must be stationary and stable or the images must be taken at a sufficient shutter speed. Shutter speed is a unit that defines how long is the cameras sensor exposed to light (hence another common synonymous term exposure time).</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p class="mb-4">For example, if the image is exposed for one tenth of a second (expressed as 1/10 in all camera systems) this is considered a slow shutter speed. In this case any camera movement while taking an image at 1/10 speed will be blurred to a degree.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p>One should always try to maximize the shutter speed to make images free of motion blur. Distance to the terrain or object and speed of the drone are contributing factors, but as a rule of thumb do not go any slower than 1/250 shutter speed at any times when the aircraft is moving.</p>
                      <!-- /wp:paragraph --></div>
                  </div>
                </li>

                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                  show: false
                }">
                <button class="flex w-full text-left" @click="show = !show">
                  <div class="w-auto mr-8 cursor-pointer" >
                    <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">4</span>
                  </div>
                  <div class="w-full mt-3">
                    <div class="flex items-center justify-between">
                      <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                        {{  translate('What is the best image brightness for photogrammetry?')  }}
                      </h3>
                      <span class="ml-4">
                        @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                      </span>
                    </div>
                  </div>
                </button>
                
                <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                  <div itemprop="text"><!-- wp:paragraph -->
                    <p class="mb-4">Images made for photogrammetry, and indeed for anything else, should look nice. If you can see the features in the image, the software will see them as well. Balancing the previously mentioned settings as well as aperture is the key to properly exposed images. Aperture is the final factor that makes up the photographs' exposure.</p>
                    <!-- /wp:paragraph -->
                    
                    <!-- wp:paragraph -->
                    <p  class="mb-4">For photogrammetric purposes it is usually best to keep the aperture wide open. Wide open means that the lens itself will let through all the light it gathers. Aperture is expressed as an f number. The smaller the f number - the more open the aperture is.</p>
                    <!-- /wp:paragraph -->
                    
                    <!-- wp:paragraph -->
                    <p  class="mb-4">For example, aperture value of f2.8 is a good small number that lets a large amount of light to the sensor. F11 on the other hand is a more closed aperture that will result in less light. Some drones have fixed aperture lenses which means that you don’t have to worry about changing it whatsoever.</p>
                    <!-- /wp:paragraph --></div>
              </li>

                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">5</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('How to deal with high ISO sensitivity?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <p class="mb-4">ISO is a unit that determines how sensitive to light the camera sensor is. The higher the number - the more camera will amplify the signal that makes the image bright. The smaller the value - the better the image quality will be obtained, but if there is not enough light in the scene that you are capturing, the result will be a too dark or even a black picture.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p class="mb-4">Balancing the shutter speed and ISO is the key to good aerial imagery. If the shutter speed is too low you will get motion blur, if the sensitivity is too high you will get low quality images cause of noise.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p class="mb-4">This is not usually a problem in well-lit situations such as a stockpile during the day, but if you feel that there is not a lot of light always remember to try to make sure that the balance between ISO and shutter speed is there without any motion blur or focusing issues.</p>
                      <!-- /wp:paragraph -->
                      
                      <!-- wp:paragraph -->
                      <p class="mb-4">As the cameras are getting better and better, motion blur issue is unaffected, but high ISO images are getting better because of advancing sensor technology. Raw images are getting easier to brighten up in post-production as a fix as well. As we cannot fix motion blur of an image, the priority should always be to avoid that, at the cost of using high ISO or getting darker images.</p>
                      <!-- /wp:paragraph -->
                    </div>
                  </div>
                </li>

                <li class="px-4 lg:px-12 py-5 border-b border-gray-50" x-data="{
                    show: false
                  }">
                  <button class="flex w-full text-left" @click="show = !show">
                    <div class="w-auto mr-8 cursor-pointer" >
                      <span :class="{'bg-primary text-white':show, 'bg-[#f5f5f5] text-gray-900': !show}" class="flex items-center justify-center w-12 h-12  text-lg font-bold rounded-full">6</span>
                    </div>
                    <div class="w-full mt-3">
                      <div class="flex items-center justify-between">
                        <h3 class="text-xl text-primary font-bold" :class="{'text-primary':show, 'text-gray-900': !show}">
                          {{  translate('Capturing images for photogrammetry')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>
                  
                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <ol class="list-decimal space-y-1">
                      <li>The overlap between the 2 consecutive photos should be at least 75% side and 75% front.</li>
                      <li>The flight altitude should be as constant as possible.</li>
                      <li>The camera position angle varies respect to the type of target scanned subject. The optimal result is acquired with the angle:
                        <ul class="list-disc space-y-1 pl-5">
                          <li>90<sup>o</sup> (nadir or top-down images), suitable for terrains and piles, orthophoto creation;</li>
                          <li>45<sup>o</sup> for the objects that are very steep or perpendicular to the ground such as buildings;</li>
                        </ul>
                      </li>
                      <li>For the objects of more complex geometry or homogeneous, flat surface:
                        <ul class="list-disc space-y-1 pl-5">
                          <li>increase the overlap between photos up to 85%;</li>
                          <li>increase the camera altitude;</li>
                          <li>use georeferencing for higher accuracy;</li>
                          <li>set camera exposure settings as accurately as possible so not to blow out any highlight or shadow detail.</li>
                        </ul>
                      </li>
                      <li>Large and tall constructions (such as buildings, towers, monuments, etc.) should be captured in few stages:
                        <ul class="list-disc space-y-1 pl-5">
                          <li>45<sup> o</sup> angled flight with consistent overlap.</li>
                          <li>90<sup> o</sup> (nadir) flight with consistent overlap.</li>
                          <li>orbital flights around objects that require more detail.</li>
                        </ul>
                      </li>
                      <li>In case of presence of a uniform or reflective surface on the terrain, increase the altitude and ensure capturing as many textured features as possible. Water, snow, sand, tin roofs and other uniform or reflective surfaces have too little key points for matching, thus they are almost impossible to reconstruct.</li>
                      <li>Plan the flight in respect with the terrain. It is recommended:
                        <ul class="list-disc space-y-1 pl-5">
                          <li>to avoid capturing the sky, i.e. the photos should preferably contain the view of the terrain.</li>
                          <li>to avoid the presence of holes on the reconstructed object, make sure that the texture of the surface is rough enough.</li>
                          <li>If multiple flights are to be made, ensure the consistent overlap between adjacent picture rows.</li>
                          <li>Building facades should be captured at 45<sup> o</sup> or less if needed.</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </li>
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
    
  </div>
</section>

@include('components.custom.full-width-cta')