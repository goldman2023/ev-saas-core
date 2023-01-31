<section class="relative" x-data="{
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