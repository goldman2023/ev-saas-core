@extends('frontend.layouts.app')

@section('content')
{{--
[{"id":"tailwind-ui.sections.marketing.hero-sections.hero-section_08","title":"Hero Section
08","thumbnail":"https:\/\/tailwindui.com\/img\/components\/hero-sections.07-card-with-background-image-xl.jpg","order":0,"data":{"title_slot":{"title":"Hero
Title","components":{"hero_title":{"title":"Title","data":{"label":"Labas222","class":"","tag":"span","id":""}}}},"text_slot":{"title":"Hero
Subtitle","components":{"hero_text":{"title":"Subtitle","data":{"label":"321","class":"","tag":"span","id":""}}}},"button_group_slot":{"title":"Buttons","components":{"hero_buttons":{"title":"Buttons","data":{"button_group":[{"label":"Link","class":"","type":"link","href":"#","target":"_self"}],"class":""}}}},"hero_info_slot":{"title":"Info
Label","components":{"hero_info_label":{"title":"Info
label","data":{"label":"","class":"","tag":"span","id":""}}}},"image_slot":{"title":"Hero
Image","components":{"hero_image":{"title":"Image","data":{"src":"uploads\/5469dff5-3707-417d-b152-d9950de45daf\/maziuko-dovana","class":"","href":null,"target":"_self","alt_text":"","options":[],"id":""}}}}},"settings":{"background":{"type":"color","color":"#fff","urls":{"mobile":"","tablet":"","desktop":""},"position":"center"},"spacing":{"mobile":{"top":"0","bottom":"0"},"tablet":{"top":"0","bottom":"0"},"desktop":{"top":"0","bottom":"0"}},"extra_classes":"labas","user_visibility":"all","responsive_visibility":"all"},"uuid":"2bdfe1d9-09da-4f33-90ec-33b8805fb6b3"},{"id":"tailwind-ui.sections.marketing.hero-sections.hero-section_01","title":"Hero
Section
01","thumbnail":"https:\/\/tailwindui.com\/img\/components\/hero-sections.01-simple-centered-xl.png","order":1,"data":{"title_slot":{"title":"Section
Title","components":{"section_title":{"title":"Title","data":{"label":"This is my
title","class":"","tag":"h1","id":""}}}},"text_slot":{"title":"Section
Text","components":{"section_text":{"title":"Text","data":{"label":"123 123 321 321 321
321","class":"","tag":"span","id":""}}}},"button_group_slot":{"title":"Buttons","components":{"buttons":{"title":"Buttons","data":{"button_group":[{"label":"Link","class":"","type":"link","href":"dsadsadsa","target":"_self"}],"class":""}}}}},"settings":{"background":{"type":"color","color":"#fff","urls":{"mobile":"","tablet":"","desktop":""},"position":"center"},"spacing":{"mobile":{"top":"0","bottom":"0"},"tablet":{"top":"0","bottom":"0"},"desktop":{"top":"0","bottom":"0"}},"extra_classes":"","user_visibility":"all","responsive_visibility":"all"},"uuid":"02063151-b328-4ae1-8184-c5271cd152a4"},{"id":"tailwind-ui.sections.marketing.hero-sections.hero-section_08","title":"Hero
Section
08","thumbnail":"https:\/\/tailwindui.com\/img\/components\/hero-sections.07-card-with-background-image-xl.jpg","order":2,"data":[],"settings":[],"uuid":"077d4ee3-1e5d-4a2a-a541-f45260d98ae8"}]


--}}
<section class="">
    @php
    $section = [];
    $section_options = '{"title_slot":{"title":"Hero Title","components":{"hero_title":{"title":"Title","data":{"label":"Convert photos to 3D models with pro-grade tools","class":"","tag":"h1","id":""}}}},"text_slot":{"title":"Hero Subtitle","components":{"hero_text":{"title":"Subtitle","data":{"label":"PixPro – professional photogrammetry for everyone. Measure easily in 3D.","class":"","tag":"h4","id":""}},"hero_info_label":{"title":"Info label","data":{"label":"1 month free trial now","class":"","tag":"span","id":""}}}},"button_group_slot":{"title":"Buttons","components":{"hero_buttons":{"title":"Buttons","data":{"button_group":[{"label":"Get started free","class":"bg-primary hover:bg-secondary-light text-white ","type":"link","href":"#","target":"_blank"}],"class":""}}}},"image_slot":{"title":"Hero Image","components":{"hero_image":{"title":"Image","data":{"src":"uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1647462577_pix-pro-home-page-image.png","class":"","href":"","target":"_self","alt_text":"Test google.com","id":""}}}},"hero_info_slot":{"title":"Info Label","components":{"hero_info_label":{"title":"Info label","data":{"label":"1 month free trial now","class":"","tag":"h2","id":""}}}}}';
    $section['settings'] = (new \App\View\Components\TailwindUi\WeComponent())->getDefaultSettings();
    // $section['settings']['extra_classes'] = 'bg-primary';
    $section['data'] = json_decode($section_options, true);
    @endphp
    <x-dynamic-component component="tailwind-ui.sections.marketing.hero-sections.hero-section_08"
        :we-data="$section['data'] ?? []" :settings="$section['settings'] ?? []" class="mt-4" />
</section>
<section>
    <div class="container">
            <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>


@endsection
