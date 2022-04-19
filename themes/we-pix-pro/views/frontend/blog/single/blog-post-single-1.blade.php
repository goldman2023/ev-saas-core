@extends('frontend.layouts.' . $globalLayout)

@section('meta')
{{-- <x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags> --}}
@endsection

@section('content')
{{-- <section class="relative" x-data="{
    tab: 'channels',
}">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
        <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
            <button type="button" @click="tab = 'channels'" :class="{'bg-primary text-white':tab == 'channels', 'gray-900':tab == 'channels'}" class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Support Channel') }}</button>
            <button type="button" @click="tab = 'videos'" :class="{'bg-primary text-white':tab == 'videos', 'gray-900':tab == 'videos'}" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Videos') }}</button>
            <button type="button" @click="tab = 'faq'" :class="{'bg-primary text-white':tab == 'faq', 'gray-900':tab == 'faq'}" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('FAQ') }}</button>
        </div>
    </div>

    <div class="w-full" x-show="tab == 'channels'">
        <p class=" text-gray-700 text-20 text-center mb-10">
            Detailed Pixpro guide and other useful bits of information can be found <a class=" text-darkGreen" href="">HERE</a>. And if you ever <br class="inline"> find yourself in need of a
            support, contact us via platform of your choice:
        </p>

        <div class="grid grid-cols-12 gap-8">
            <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                <img src="https://c.neh.tw/thumb/f/720/m2H7H7A0N4m2G6H7.jpg" class="w-[65px] h-[65px] mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Join our Discord support server</h4>
                <p class=" text-14 text-gray-700 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
            </a>
            <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="w-[65px] h-[65px] mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Join our Discord support server</h4>
                <p class=" text-14 text-gray-700 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
            </a>
            <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                <img src="https://e7.pngegg.com/pngimages/402/714/png-clipart-email-logo-email-computer-icons-signature-block-mail-miscellaneous-trademark.png" class="w-[65px] h-[65px] mx-auto flex" alt="">
                <h4 class="text-gray-900 font-medium text-20 py-2">Join our Discord support server</h4>
                <p class=" text-14 text-gray-700 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
            </a>
        </div>
    </div>
    <div class="w-full" x-show="tab == 'videos'">
        videos
    </div>
    <div class="w-full" x-show="tab == 'faq'">
        faq
    </div>
  </div>
</section>


<section class="section-padding" style=" background-image: url(assets/images/Shape.png); background-repeat: no-repeat; background-position: top left;">
    <div class="container">
        <div class="supportTab">



            <div class=" mt-4">
                <!-- Tabs -->
                <ul id="tabs" class="flex justify-between bg-darkGray p-2 rounded-lg border-blackborder max-w-2xl w-full mx-auto">
                    <li class=" border-black "><a id="default-tab" class="font-sm font-medium rounded-lg mx-3 px-6 py-2 block w-176 text-center bg-darkGreen text-white" href="#first">Support Channels</a></li>
                    <li class="border-l border-blackborder"><a class="font-sm font-medium mx-3 px-6 text-gray-800 py-2 block w-176 text-center rounded-lg" href="#second">Videos</a></li>
                    <li class="border-l border-blackborder"><a class="font-sm font-medium mx-3 px-6 text-gray-800 py-2 block w-176 text-center rounded-lg" href="#third">FAQ</a></li>
                </ul>
            <p class=" text-dark2 text-f20 text-center mt-4 mb-10">Detailed Pixpro guide and other useful bits of information can be found <a class=" text-darkGreen" href="">HERE</a>. And if you ever <br class="inline"> find yourself in need of a
                support, contact us via platform of your choice:</p>
                    <!-- Tab Contents -->
                    <div id="tab-contents">
                        <div id="first" class="p-4">
                            <div class="grid grid-cols-12 gap-8">
                                <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                                    <img src="assets/images/supportLogo1.png" class="mx-auto flex" alt="">
                                    <h4 class="text-lightBlack font-medium text-f20 py-2">Join our Discord support server</h4>
                                    <p class=" text-sm text-dark2 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
                                </a>
                                <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                                    <img src="assets/images/supportLogo2.png" class="mx-auto flex" alt="">
                                    <h4 class="text-lightBlack font-medium text-f20 py-2">Join our Discord support server</h4>
                                    <p class=" text-sm text-dark2 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
                                </a>
                                <a href="#" class="px-4 py-4 bg-white col-span-4 text-center border-blackborder border rounded-sm hover:shadow-3xl transition-all duration-300">
                                    <img src="assets/images/supportLogo3.png" class="mx-auto flex" alt="">
                                    <h4 class="text-lightBlack font-medium text-f20 py-2">Join our Discord support server</h4>
                                    <p class=" text-sm text-dark2 leading-6">Text and voice channels for live support as well as announcements for keeping you updated on all the latest Pixpro news.</p>
                                </a>
                            </div>
                        </div>
                        <div id="second" class="p-4 hidden">
                            <!-- playVideo -->
                                <div class=" grid grid-cols-12 gap-8">
                                    <div class="col-span-6">
                                        <div class="video-wrapper">
                                            <div class="video-container" id="video-container">
                                                <video controls="" id="video" preload="metadata" class=" rounded-md" poster="./assets/images/videoImage1.png">
                                                    <source src="//cdn.jsdelivr.net/npm/big-buck-bunny-1080p@0.0.6/video.mp4" type="video/mp4">
                                                </video>
                                                <h4 class=" text-f24 text-lightBlack font-bold mt-4">Local processing – Getting started</h4>
                                                <!--                             
                                                <div class="play-button-wrapper">
                                                    <div title="Play video" class="play-gif" id="circle-play-b">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                            <path d="M40 0a40 40 0 1040 40A40 40 0 0040 0zM26 61.56V18.44L64 40z" />
                                                        </svg>
                                                    </div>
                                                </div> -->
                                            </div>
                                    </div>
                                </div>
                                    <div class="col-span-6">
                                        <div class="video-wrapper">
                                            <div class="video-container" id="video-container">
                                                <video controls="" id="video" preload="metadata" class=" rounded-md" poster="./assets/images/videoImage2.png">
                                                    <source src="//cdn.jsdelivr.net/npm/big-buck-bunny-1080p@0.0.6/video.mp4" type="video/mp4">
                                                </video>
                                                <h4 class=" text-f24 text-lightBlack font-bold mt-4">Cloud processing – Getting started</h4>
                                            </div>
                                    </div>
                                </div>
                            <!--/ playVideo -->
                        </div>
                        </div>
                        <div id="third" class="p-4 hidden">
                            <h3 class=" text-lgfs3 font-bold text-lightBlack text-center pb-8 border-blackborder border-b">Pre-run and requirements</h3>

                    
            <ul class="accordion-list list-unstyled">
                <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                    <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        How do I install the software?
                        <span class="ni ni-minus">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                        </span>
                    </h5>
                    <div class="accordion-desc py-4">

                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Open the installer executable, or double-click on the shortcut to it.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">If you are asked about it, allow changes to be made to your computer.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Pixpro setup will pop up. Read the instructions, then proceed to next step by clicking Next.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">In order to proceed, click I Agree.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be stored.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The green progress bar represents the process. A shortcut
                            will be created on your desktop that will launch the application.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run Pixpro checked, the application will start automatically.</p>
                        </div>
                    
                    </div>
                </li>
                <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                    <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        What are the minimum hardware requirements?
                        <span class="ni ni-minus">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                        </span>
                    </h5>
                    <div class="accordion-desc py-4" style="display: none;">

                        
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">In order to proceed, click I Agree.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be stored.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The green progress bar represents the process. A shortcut
                            will be created on your desktop that will launch the application.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run Pixpro checked, the application will start automatically.</p>
                        </div>
                    
                    </div>
                </li>
                <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                    <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                    What are the recommended hardware requirements?
                        <span class="ni ni-minus">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                        </span>
                    </h5>
                    <div class="accordion-desc py-4" style="display: none;">
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be stored.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The green progress bar represents the process. A shortcut
                            will be created on your desktop that will launch the application.</p>
                        </div>
                        <div class="flex items-start gap-3 mt-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run Pixpro checked, the application will start automatically.</p>
                        </div>
                    
                    </div>
                </li>
            
            </ul>

            <div class="mt-20">
                <h3 class=" text-lgfs3 font-bold text-lightBlack text-center pb-8 border-blackborder border-b">Capturing photos for photogrammetry
                </h3>
                
                <ul class="accordion-list list-unstyled">
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        What kind of photos are used for photogrammetry purposes?
                            <span class="ni ni-plus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                
                            <div class="">
                            
                                <p class="mb-0 text-lightDark text-lg">Technically photos for photogrammetric purposes can be captured with any camera. But some things do work better than
                                others. Photogrammetric algorithms work best with generally high-quality imagery. High quality photos can be obtained
                                from many types of imaging devices as longs the technique and specifications are up to the job.</p>
                                <p class="text-lightDark text-lg my-3">A few key specifications regarding the equipment are recommended:</p>
                                <p class="text-lightDark text-lg my-3"><b>1. Resolution:</b> 12 megapixels is a good starting point. Any less than that introduces a little risk that not enough
                                detail could be captured for good 3D reconstruction results.</p>
                                <p class="text-lightDark text-lg my-3"><b>2. Lens focal length:</b> anything between 16 and 135 millimeters of 35 mm equivalency should be good for photogrammetry, sweet spot being 24 - 50
                                mm equivalent lenses. All manufacturers specify the equivalent lens focal length because it’s the most common unit to
                                determine how wide or zoomed-in the lens is. Always refer to the cameras or lens' manual to find the equivalent focal
                                length. Anything wider (less) than 16 millimeters is ultra-wide angle which might introduce heavy distortion that might
                                compromise reconstruction results. Anything longer or more 'tele' than 135 millimeters can result in shallow depth of
                                field which also can make 3D reconstruction impossible. Specialty lenses such as fish-eye, tilt-shift, soft-focus should
                                be generally avoided. Although macro lenses are usually well suited for photogrammetry due to their excellent optical
                                properties.</p>
                                    <p class="text-lightDark text-lg my-3"><b>5. GPS geotagging:</b> GPS data embedded in the photo helps to create projects with scale and position which is required if any measurements
                                    are to be made. This is most applicable to drones. Almost all drones embed GPS data because having a GPS sensor is an
                                    essential part of their operation. Some handheld cameras and most smartphones have GPS as well.</p>
                            </div>
                        
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                            How to manage the focus of the camera?
                            <span class="ni ni-plus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                
                
                            <div class="">
                                <p class="mb-0 text-lightDark text-lg">Technically photos for photogrammetric purposes can be captured with any camera.
                                    But some things do work better than
                                    others. Photogrammetric algorithms work best with generally high-quality imagery. High quality photos can be
                                    obtained
                                    from many types of imaging devices as longs the technique and specifications are up to the job.</p>
                                <p class="text-lightDark text-lg my-3">A few key specifications regarding the equipment are recommended:</p>
                                <p class="text-lightDark text-lg my-3"><b>1. Resolution:</b> 12 megapixels is a good starting point. Any less than that
                                    introduces a little risk that not enough
                                    detail could be captured for good 3D reconstruction results.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                            How to deal with motion blur in photos?
                            <span class="ni ni-plus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        How to deal with high ISO sensitivity?
                            <span class="ni ni-plus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                    What is the best image brightness for photogrammetry?
                            <span class="ni ni-plus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 border-b border-blackborder open">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                    Capturing images for photogrammetry
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            
                        </div>
                    </li>
                
                </ul>

            </div>
            <div class="mt-20">
                <h3 class=" text-lgfs3 font-bold text-lightBlack text-center pb-8 border-blackborder border-b">Accuracy
                </h3>
                
                <ul class="accordion-list list-unstyled">
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        How to get a high resolution orthophoto?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4">
                
                            <div class="">
                            
                                <p class="mb-0 text-lightDark text-lg">Orthophoto is an orthorectified image representing the area from above. DEM is needed to make a true orthophoto.</p>
                                <p class="text-lightDark text-lg my-3">In the Orthophoto dialogue window, select the digital elevation map for the basis. To increase or decrease the
                                resolution of the orthophoto, select the GSD value. The smaller the value, the higher the resolution.</p>
                                <p class="text-lightDark text-lg my-3">Suggested value is 4 times smaller than the used digital elevation map. The value can be even smaller, but it might
                                cause the longer processing.</p>
                                <p class="text-lightDark text-lg my-3">It is no use going smaller than the photo GSD that is calculated during the flight planning stage, which is the maximum
                                quality available. If there is need for better quality, a lower altitude flight must be performed.</p>
                                    
                            </div>
                        
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                            What GCPs (ground control points) are used for?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                
                
                            <div class="">
                                <p class="mb-0 text-lightDark text-lg">Technically photos for photogrammetric purposes can be captured with any camera.
                                    But some things do work better than
                                    others. Photogrammetric algorithms work best with generally high-quality imagery. High quality photos can be
                                    obtained
                                    from many types of imaging devices as longs the technique and specifications are up to the job.</p>
                                <p class="text-lightDark text-lg my-3">A few key specifications regarding the equipment are recommended:</p>
                                <p class="text-lightDark text-lg my-3"><b>1. Resolution:</b> 12 megapixels is a good starting point. Any less than that
                                    introduces a little risk that not enough
                                    detail could be captured for good 3D reconstruction results.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                            How to prepare a GCP text file?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        Can I modify the density of the contour lines?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            
                        </div>
                    </li>
                    
                
                </ul>

            </div>
            <div class="mt-20">
                <h3 class=" text-lgfs3 font-bold text-lightBlack text-center pb-8 border-blackborder border-b">Creating a 3D structure
                </h3>
                
                <ul class="accordion-list list-unstyled">
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                    How to choose the best processing speed?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4">
                
                            <div class="">
                            
                                <p class="mb-0 text-lightDark text-lg">Processing speed setting affects the reconstruction speed and quality.</p>
                                <p class="text-lightDark text-lg my-3"> <b>Fast</b> processing takes the least amount of time, but it also requires the best possible image quality. This means that
                                the 'Fast' setting is best for those who are confident that the photos taken for the reconstruction are more than
                                suitable. This includes the overlap, general image quality and object coverage with room to spare.</p>
                                <p class="text-lightDark text-lg my-3"> <b>Medium</b> setting, the default, is usually a good choice for most cases.</p>
                                <p class="text-lightDark text-lg my-3"> <b>Slow</b> setting allows using poorer quality pictures and provides more coverage while taking considerably more time to
                                finish. If the Slow reconstruction setting combined with optimize cameras setting fail – there’s a high probability that
                                the pictures were taken inadequately for the 3D reconstruction.</p>
                                    
                            </div>
                        
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        How to make a reconstruction from a part of a photo set?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                
                
                            <div class="">
                                <p class="mb-0 text-lightDark text-lg">Technically photos for photogrammetric purposes can be captured with any camera.
                                    But some things do work better than
                                    others. Photogrammetric algorithms work best with generally high-quality imagery. High quality photos can be
                                    obtained
                                    from many types of imaging devices as longs the technique and specifications are up to the job.</p>
                                <p class="text-lightDark text-lg my-3">A few key specifications regarding the equipment are recommended:</p>
                                <p class="text-lightDark text-lg my-3"><b>1. Resolution:</b> 12 megapixels is a good starting point. Any less than that
                                    introduces a little risk that not enough
                                    detail could be captured for good 3D reconstruction results.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                        What is the difference between sparse and dense clouds?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg class=" flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Please, wait until the installation procedure is completed. The
                                    green progress bar represents the process. A shortcut
                                    will be created on your desktop that will launch the application.</p>
                            </div>
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Click Finish to complete the installation. If you leave Run
                                    Pixpro checked, the application will start automatically.</p>
                            </div>
                
                        </div>
                    </li>
                    <li class="accordion-list-item px-3 py-3 mb-2 open border-b border-blackborder">
                        <h5 class="accordion-title flex justify-between items-center text-f24 text-lightBlack">
                    What density of the point cloud to select?
                            <span class="ni ni-minus">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1663 10.5L13.9997 18.6667L5.83301 10.5" stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                            </span>
                        </h5>
                        <div class="accordion-desc py-4" style="display: none;">
                            <div class="flex items-start gap-3 mt-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                
                                <p class="mb-0 text-lightDark text-lg">Specify the directory where the program and its files will be
                                    stored.</p>
                            </div>
                            
                        </div>
                    </li>
                    
                
                </ul>

            </div>


            
        </div>
       
    </div>
        </div>
    </div>
</div>
</section> --}}
@endsection
