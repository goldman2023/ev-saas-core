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
        <div x-cloak class="relative self-center bg-gray-100 rounded-lg p-0.5 flex flex-col sm:flex-row justify-center items-center gap-2">
            <button type="button" @click="tab = 'channels'" :class="{'bg-primary text-white':tab == 'channels', 'gray-900':tab == 'channels'}" class="min-w-[180px] relative w-full border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8 bg-primary text-white gray-900">Support Channel</button>
            <button type="button" @click="tab = 'videos'" :class="{'bg-primary text-white':tab == 'videos', 'gray-900':tab == 'videos'}" class="min-w-[180px] ml-0.5 relative w-full border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">Videos</button>
            <button type="button" @click="tab = 'faq'" :class="{'bg-primary text-white':tab == 'faq', 'gray-900':tab == 'faq'}" class="min-w-[180px] ml-0.5 relative w-full border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">FAQ</button>
        </div>
    </div>

    <iframe id="video_iframe_template" class="hidden w-full h-[200px] md:h-[300px] mb-6" src="" ></iframe>

    <div class="w-full" x-cloak>
      <div class="w-full" x-show="tab == 'channels'">
        <p class=" text-gray-700 text-16 sm:text-20 text-center mb-10">
          {{ translate('Detailed Pixpro guide and other useful bits of information can be found') }} <a href="https://help.pix-pro.com/" class="text-primary" target="_blank">{{ translate('HERE') }}</a>. {{ translate('And if you ever find yourself in need of a support, contact us via platform of your choice:') }}
        </p>

        <div class="grid grid-cols-12 gap-8">
            <a href="https://discord.com/invite/XBhmAxzXnp" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img class="w-[65px] h-[65px] object-contain mx-auto flex" alt=""
                      src="data:image/png;base64,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">
                <h4 class="text-gray-900 font-medium text-20 py-2">{{ translate('Join our Discord support server') }}</h4>
                <p class=" text-14 text-gray-700 leading-6">{{ translate('Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.') }}</p>
            </a>
            <a href="https://www.facebook.com/groups/pixprosupport" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img class="w-[65px] h-[65px] mx-auto flex" alt=""
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAARjSURBVHgB7Zy9bxM9HMe/vrR5ihKkZHiAAkM6AAMMLQMj0AUGQGKDDZCYWBATExN/AGJhQuJtgQWxwFpATAyQAQbCQBZUUYYGmtLSkhj/GlU92vP5Lk4dp/f7SFGjnk/VfeqXrx3HAMMwDMMw/UGgS75IWRpeRiW/hHEMKFKgEQRoNEdQHROigS5ILfDbvDwrAlyVEsexhRACL1stPBgtivup7ktacHpBVnLAva0mLoJ6W2BydJuoJymcSOBMU46rklOqypeQDRrLQ5jcmxdVU0GjwJWa18b7DMlbpaFq4oSpJgYwEMhM1bwwJeqyTIViBU435UX1o4KMQv39t5/ybFyZWIG5HC4g44hhXI29rrswOytLS/9hFgx+/UZ5rBydE7U1cHFkcANyrxku6LuxId2FoK0Gjq7nKb1nbpn6ZPX6BTSXosuMFoDDO9Bzcp3ZVmSk0QpsS5SCPgskaU9qwKuvwOeEncm+MvDoBJwxBE+5+1HJ+9SRmAYS/W5mc2piFN4JJGHX33QkhCEh+1Qa3a2aaXF4431U/nm98356Hs7wTuCVqbXmul2JOrdfvQ503ptYFegSrwTeer8mjwaEO5Odnz5jnMq5gpodDRjEoMgjvBFIg8Yqlw8NhjzCC4FNNXA8/9J5T+JOVTAweNEHhkfco3vMZWmwqDX+DdS6cL3ZeCGwFgrJx2IEUjO/+wFGXGVAwguB4dxW1MQVauZheRRrivmN5Sj2uOw/vcuB2/PRvw/X0lNjwI0j8AJvRmET4Vp6+H94w8AI9BUWaInTPpAWCl6ovDe3LnLUfiAVr79GLxiMFt1nSGcC6YFpoaAXKyW0PkivKCiQ0zTQFc6a8OeGWR7FD10EObY3WTyhoJ12DdEGZzUw3Gwpq60PzJTrdhX191M+fHhSvzJ9q7p2jWYlSZa/ekFfcuD+UnezBZKiu8+VsPXwKGwJC7SEBVrCAi3pyyCiC8K0SBAXVSjj6aKQy0/iwjgTGBajC8L0mcjTM9EjKuW7m2+R+m9tNs6aMMUPyn9xUADWrSwnrWGXD8IpTpvwtQngdGXjTOFxrdOskxIVxAna1uE6DzrvA+kh17P6gVJSug3imwGPwpawQEtYoCUs0BIWaAkLtIQFWsICLWGBlrBAS1igJSzQEhZoCQu0xLv9gbQuGPlFmu/wEu8E0ndFTOg2YfYDL5rw+RTbcqmcaSO6S7yogbRKTTuqaAPSXMxue6p5E31YiQ4EtIfyaAW28qgGf+CMuJ1Z/YZON9Je010ozKMOZoXmIrTnx2gFlsuiQcchIeOQA915CUTsICLbuI2M0wIexF03fql/ZkFOZeC8rGgE6ju3ibG4IsYYo/4Dl5Tlro6GG2TomduAcbe1UeDK2VFtTGZJ4sqztpOd4JYoSO8oimpLYIKqNLY4ks4RVM9Kz5ykfOqDTaYX5MUccGGr9YskTqhBc2dBPEtzn9URoCOLGKcDeoQc6NPdqvMF1Ls9ApRhGIZhmH7xF3O7NTjaVeBwAAAAAElFTkSuQmCC">
                <h4 class="text-gray-900 font-medium text-20 py-2">{{ translate('Join our Facebook support group') }}</h4>
                <p class=" text-14 text-gray-700 leading-6">{{ translate('Facebook is your platform of choice? Seek for help by joining our Facebook support group.') }}</p>
            </a>
            <a href="/page/contact" target="_blank" class="px-4 py-4 bg-white col-span-12 md:col-span-4 text-center border-blackborder border rounded-sm shadow-md hover:shadow-xl transition-all duration-300">
                <img class="w-[65px] h-[65px] mx-auto flex" alt=""
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUBSURBVHgB7Zw9bxNJGMef8cWRo3CnWLqzdMoVpkF3okmaFEeTiJeGBvgABGoiUcMHIDVSqCF8AELNi3BDYwrcIBAUuAmIgJRIYIFw4mH/uwweb3b2JTOzm2TnJ+Vtd+3Z/c8zz/zniTVEDofD4XA4ioHRHuH87RT1q036Pj5DBxXGt6hS2aLalw5jR7doD2QWkPc+nPMaver9Ok+Hi5b3dKtsonEnw2vSC8i/vm8Sjd2mwydcCNYl6i+wib+7qa5OcxH/sjHjRd0TL+SnqAww8oY2X2DjjU7ypQn4kcerz0sjngAi8u3ZpEisUCLV8kSeDKepnykrllgB+deNS973JpWXeX/SjCE+AlllkcpO4DiUKHMg39ycotr2JjmIamN1xuqRPlEdgbXtg2uQTdPvNVWn1AIOWPkmDhU76tWWWsDKwAmYghQ2xhGHE1ATJ6AmTkBNnICaOAE1cQJqMkY2eH2X6GPbc/CfaV9Q/Z1o+hRR8xyZxqyAEKx1kWjzFe071h8TvVn16it3A0ENYXYIP1/en+IJcG8YHQYxG4Hrj3Yfm5wmOn6FCuHFLaLe+uix16tG78ecgLjRqJyH42+8Xv9/JRAzD0QqCYsnzuG4oXuxNwtPnxz+jqHTWox+INOgjQfnR1NJY45sYU/AE17EHbs4/BsPZlvEqDZwD/OrZAu7PnDm2mi++RUdL8k4G8+C95bFQ9u4B4vYN9LHl0YfAjno4QWzs2H3fpDz5Bzsd94S2SaflQiGEYa07L86y8EsqQveoy11ENoIpw+L5LeUw6SCXCTPfi9W9ET0O2Fl+DfeG23IE5hl8l0L1/+LFvHZ9WzLPlzbvj6aBoR4aCNH8i8mRD3o2zW1bwsjPF53bXis/u/ujsmJYqoxUUMtjVeM8ngoEGB9W4B4oLhylkj2YZujEhHWJ8rjzS0bLQ5kpfh6IKxG2HAjylA9EcDjRYln2eOloXgBIY4sFkCee7oUTBL4Cns8gNfYMOQZsVNQTQvEgRVRET6HoSqERDTCkCOCi6r2UFERKGxIWCAMybOPoicEMfGEhy1sUDujDTJI/gKKHCfbEIhz+l6Q14RQsoiy9cE1YZHxXuF1cE7kK+C7x7sfFKWmM2ujvlAI1jwfCIbzUYLKZapfHXOf8iS/HIjhGi4gxM2kEGnuBikRIsrLQT81XAvEzCkv2o9A4e1k8YQHNGFDMIlAaNkLQtScCrh2BRTmd6M9PIbIwZA0ueDHUA8Pc7SJti1bHXsCIuJgM+QowLIr/KCmEB0TNuW4BxNlMwX2cmCURbFdo8MwRjv4KYsml7wMY05ARIBsdGUg3Pgf+c2Qk/8EbUZVvXGPBkeA2Qg8thjd24b/ma0FPuJhELM5EL2ec0EzE6gbzpotQJiNQAwPrCiwMsBifz99uOivOSs52M4kAluBrxLgPh+oiRNQEyegJk5ATZyAmjgBNXECauIETMOAKzflUQv4GyVu+VEasLuR6pTyRb1qlxwBtTFlMCkFZPX6FjHWIkdLtV8CiM+BO3STSg+P/YB18s5F3z49Ic7nqZTwLptoHI27InkW5v3LxNmetoY70HDynnlnIemyRAH9vaMGg4VSiQjxBjzVDm6pfCA70ugQ688ipOmww6hFbHvWf+ZUl2fE308LW0IdtrwI4XbYTTb5Z6b/fOltAfrtyIy/QY+/09lBZdChyV53r1uAOhwOh8PhKIofGYy/wlQysUkAAAAASUVORK5CYII=">
                <h4 class="text-gray-900 font-medium text-20 py-2">{{ translate('Contact us directly via email') }}</h4>
                <p class=" text-14 text-gray-700 leading-6">{{ translate('Prefer writing an email?') }}</p>
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
          <div class="col-span-12 md:col-span-6 flex flex-col" @click="replaceVideo($el.querySelector('.iframe-wrapper'), video_src)" x-data="{video_src: 'https://www.youtube.com/embed/w8DLPMomOW0'}">
            <div class="cursor-pointer relative iframe-wrapper h-[200px] md:h-[300px] mb-6 overflow-hidden">
              {{-- <div class="absolute w-full h-full bg-gradient-to-b from-transparent to-primary"></div> --}}
              <div class="absolute flex justify-center top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] btn-primary  !shadow-lg !border !border-gray-300 ">
                {{ translate('Click here to play') }}
              </div>
              <img src="https://i.ytimg.com/vi/8rXemRWyKMM/hqdefault.jpg" class="w-full h-full object-cover cursor-pointer rounded-lg border border-gray-200" />
            </div>
            <strong class="text-24">{{ translate('Local processing – Getting started') }}</strong>
          </div>
          <div class="col-span-12 md:col-span-6 flex flex-col" @click="replaceVideo($el.querySelector('.iframe-wrapper'), video_src)" x-data="{video_src: 'https://www.youtube.com/embed/PXdJRm-d_b8'}">
            <div class="cursor-pointer relative iframe-wrapper h-[200px] md:h-[300px] mb-6">
              <div class="absolute items-center top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] btn-primary !shadow-lg !border !border-gray-300">
                {{ translate('Click here to play') }}
              </div>
              {{-- TODO: Change thumbnails --}}
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
                    <ol class="list-decimal space-y-1  pl-5"><li>Open the installer executable, or double-click on the shortcut to it.</li><li>If you are asked about it, allow changes to be made to your computer.</li><li>Pixpro setup will pop up. Read the instructions, then proceed to next step by clicking<em> Next</em>.</li><li>In order to proceed,&nbsp;click I <em>Agree.</em></li><li>Specify the directory where the program and its files will be stored.</li><li>Please, wait until the installation procedure is completed. The green progress bar represents the process. A shortcut will be created on your desktop that will launch the application.</li><li>Click <em>Finish</em> to complete the&nbsp;installation. If you leave<em> Run Pixpro </em>checked, the application will start automatically.</li></ol>
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
                      <ol class="list-decimal space-y-2  pl-5"><li><strong>Resolution:</strong> 12 megapixels is a good starting point. Any less than that introduces a little risk that not enough detail could be captured for good 3D reconstruction results.</li><li><strong>Lens focal length:</strong> anything between 16 and 135 millimeters of 35 mm equivalency should be good for photogrammetry, sweet spot being 24 - 50 mm equivalent lenses. All manufacturers specify the equivalent lens focal length because it’s the most common unit to determine how wide or zoomed-in the lens is. Always refer to the cameras or lens' manual to find the equivalent focal length. Anything wider (less) than 16 millimeters is ultra-wide angle which might introduce heavy distortion that might compromise reconstruction results. Anything longer or more 'tele' than 135 millimeters can result in shallow depth of field which also can make 3D reconstruction impossible. Specialty lenses such as fish-eye, tilt-shift, soft-focus should be generally avoided. Although macro lenses are usually well suited for photogrammetry due to their excellent optical properties.</li><li><strong>GPS geotagging:</strong> GPS data embedded in the photo helps to create projects with scale and position which is required if any measurements are to be made. This is most applicable to drones. Almost all drones embed GPS data because having a GPS sensor is an essential part of their operation. Some handheld cameras and most smartphones have GPS as well.</li></ol>
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
                    <ol class="list-decimal space-y-1 pl-5">
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

          {{-- Accuracy --}}
          <section class="py-10 2xl:py-40">
            <div class="container px-4 mx-auto">
              <div class="text-center">
                <h2 class="text-28 font-bold font-heading">{{ translate('Accuracy') }}</h2>
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
                          {{ translate('How to get a high resolution orthophoto?') }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <div itemprop="text"><!-- wp:paragraph -->
                        <p class="pb-4">Orthophoto is an orthorectified image representing the area from above. DEM is needed to make a true orthophoto.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p class="pb-4">In the Orthophoto dialogue window, select the digital elevation map for the basis. To increase or decrease the resolution of the orthophoto, select the GSD value. The smaller the value, the higher the resolution.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p class="pb-4">Suggested value is 4 times smaller than the used digital elevation map. The value can be even smaller, but it might cause the longer processing.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p >It is no use going smaller than the photo GSD that is calculated during the flight planning stage, which is the maximum quality available. If there is need for better quality, a lower altitude flight must be performed.</p>
                        <!-- /wp:paragraph --></div>
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
                          {{  translate('What GCPs (ground control points) are used for?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text"><!-- wp:paragraph -->
                      <p class="mb-4">Ground Control points (GCPs) are not obligatory for good 3D reconstruction. But they can be used for extremely accurate Georeferencing and scaling, meaning that the measurements will be even more accurate and the placement of the reconstructed terrain is flawless on an absolute scale.</p>
                      <!-- /wp:paragraph -->

                      <!-- wp:paragraph -->
                      <p>In case of perfect conditions consumer grade GPS device (such as drone) can provide horizontal accuracy up to 5 meters and vertical up to 10. With professional survey grade ground control points, accuracy of a few centimeters can be achieved. As an alternative Real Time Kinematic (RTK) or Post Process Kinematic (PPK) systems can be used which utilize a base station for GPS signal correction in real time or in post-processing. Drones and cameras equipped with RTK or PPK compatible devices are an order of magnitude more expensive but provide comparable accuracy to survey grade GCP's while eliminating the need to physically measure GCP's.</p>
                      <!-- /wp:paragraph -->
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
                          {{  translate('How to prepare a GCP text file?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text">
                      <p class="mb-4">GCP information is usually stored in simple text file formats such as .txt and .csv. These files may come from the professional surveying station, or they can be created by the user.</p>
                      <p class="mb-4">To create a GCP text file one must follow a simple column structure. In each row of text data should contain the same structure. The most convenient and simple line structure for the GCP data would be: GCP label-space-latitude-space-longitude-space-altitude. Using this structure we can create a text document using notepad that should look like this.</p>
                      <p>Coordinates can be entered in any coordinate system, and the coordinate system can be selected while importing the file.</p>
                    </div>
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
                            {{  translate('Can I modify the density of the contour lines?')  }}
                          </h3>
                          <span class="ml-4">
                            @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                          </span>
                        </div>
                      </div>
                    </button>

                    <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                      <div itemprop="text"><!-- wp:paragraph -->
                        <p class="pb-4">Yes. In the <em>Contour Lines</em> dialogue window, select the digital elevation map for the basis. Set the interval value and offset value if needed. The smaller the interval value the denser the contour lines. The default value is 1 meter.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p class="pb-4">Height Offset just offsets the lines up or down by a defined amount.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>The contour lines can be viewed in the map or 3D view section.</p>
                        <!-- /wp:paragraph -->
                      </div>
                    </div>
                </li>
              </ul>
            </div>
          </section>


          {{-- Creating a 3D structure --}}
          <section class="py-10 2xl:py-40">
            <div class="container px-4 mx-auto">
              <div class="text-center">
                <h2 class="text-28 font-bold font-heading">{{ translate('Creating a 3D structure') }}</h2>
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
                          {{ translate('How to choose the best processing speed?') }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text">
                      <p class="pb-4">Processing speed setting affects the reconstruction speed and quality.</p>

                      <p class="pb-4"><strong>Fast</strong> processing takes the least amount of time, but it also requires the best possible image quality. This means that the 'Fast' setting is best for those who are confident that the photos taken for the reconstruction are more than suitable. This includes the overlap, general image quality and object coverage with room to spare.</p>

                      <p class="pb-4"><strong>Medium</strong> setting, the default, is usually a good choice for most cases.</p>

                      <p><strong>Slow</strong> setting allows using poorer quality pictures and provides more coverage while taking considerably more time to finish. If the Slow reconstruction setting combined with optimize cameras setting fail – there’s a high probability that the pictures were taken inadequately for the 3D reconstruction.</p>
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
                          {{  translate('How to make a reconstruction from a part of a photo set?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text">
                      <p class="pb-4">There are two possible ways to select a bundle of photos for reconstruction:</p>

                      <ol class="list-decimal space-y-1 pl-5"><li>After uploading a photo set, select the photos from the list on the Layers Panel by checking / unchecking the relevant photos. Then click <em>Start 3D Reconstruction</em>. The reconstruction will be performed only from the checked photos.</li><li>After uploading photo set, select the photos on the map by drawing the polygon around the cameras. To do this, right-click the Photos on the Layers Panel. Click <em>Select workspace area</em>, and start marking around the needed area on the map. When finished marking, right-click to close the perimeter of the selected area. The photos within only the selected area will be used for reconstruction. Please note that the workspace selection option can be done only when the photos come with the GPS data in order to display them on the map.</li></ol>
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
                          {{  translate('What is the difference between sparse and dense clouds?')  }}
                        </h3>
                        <span class="ml-4">
                          @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                        </span>
                      </div>
                    </div>
                  </button>

                  <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                    <div itemprop="text">
                      <p class="pb-4"><strong><em>Sparse point cloud</em></strong> is only the first stage of creating a workable model. In the sparse point cloud, as the name suggests, there are only few points in comparison to the dense point cloud, so the object itself can be hard to discern at this stage.</p>

                      <p><strong><em>Dense point cloud</em></strong> is the second stage of processing, and it is required to start measuring and creating digital elevation maps and orthophotos down the line. Dense point cloud creation is also the lengthiest step.</p>
                    </div>
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
                            {{  translate('What density of the point cloud to select?')  }}
                          </h3>
                          <span class="ml-4">
                            @svg('heroicon-s-chevron-down', ['class' => 'w-6 h-6 text-primary', ':class' => "{'rotate-180':show}"])
                          </span>
                        </div>
                      </div>
                    </button>

                    <div class="mt-6 mb-4 max-w-3xl border-l-2 border-gray-50 pl-4 lg:pl-10" x-show="show">
                      <div itemprop="text"><!-- wp:paragraph -->
                        <p class="pb-4"><strong>High</strong> density point cloud will provide more points and better GSD values later as a consequence, but it will take longer to create.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p class="pb-4"><strong>Low</strong> density point cloud will take less time to process while providing fewer points.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Medium</strong> density is a happy medium.</p>
                        <!-- /wp:paragraph -->
                      </div>
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
