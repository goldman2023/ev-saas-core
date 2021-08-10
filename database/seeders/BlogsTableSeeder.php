<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('blogs')->count() == 0) {
            \DB::table('blogs')->delete();

            \DB::table('blogs')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'category_id' => 1,
                        'title' => 'Vitae voluptatem au',
                        'slug' => 'Ut-molestias-eos-ut',
                        'short_description' => 'Sunt soluta voluptat',
                        'description' => '<hr style="margin: 0px; padding: 0px; clear: both; border-top: 0px; border-right-color: initial; border-bottom-color: initial; border-left-color: initial; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0)); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: center;"><div id="Content" style="margin: 0px; padding: 0px; position: relative; font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: center;"><div id="bannerL" style="margin: 0px 0px 0px -160px; padding: 0px; position: sticky; top: 20px; width: 160px; height: 10px; float: left; text-align: right;"><div id="div-gpt-ad-1474537762122-2" data-google-query-id="CKS09NLS7u8CFQaMmgodvi4EhQ" style="margin: 0px; padding: 0px;"><div id="google_ads_iframe_/15188745/Lipsum-Unit3_0__container__" style="margin: 0px; padding: 0px; border: 0pt none;"><iframe id="google_ads_iframe_/15188745/Lipsum-Unit3_0" title="3rd party ad content" name="google_ads_iframe_/15188745/Lipsum-Unit3_0" width="160" height="600" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" data-google-container-id="2" data-load-complete="true" style="margin: 0px; padding: 0px; border-width: 0px; border-style: initial; vertical-align: bottom; width: 160px; height: 600px;"></iframe></div></div></div><div id="bannerR" style="margin: 0px -160px 0px 0px; padding: 0px; position: sticky; top: 20px; width: 160px; height: 10px; float: right; text-align: left;"><div id="div-gpt-ad-1474537762122-3" data-google-query-id="CLTo9dLS7u8CFQaMmgodvi4EhQ" style="margin: 0px; padding: 0px;"><div id="google_ads_iframe_/15188745/Lipsum-Unit4_0__container__" style="margin: 0px; padding: 0px; border: 0pt none; display: inline-block; width: 160px; height: 600px;"><iframe frameborder="0" src="https://50213f9587319e69ce8c960caa72e030.safeframe.googlesyndication.com/safeframe/1-0-38/html/container.html" id="google_ads_iframe_/15188745/Lipsum-Unit4_0" title="3rd party ad content" name="" scrolling="no" marginwidth="0" marginheight="0" width="160" height="600" data-is-safeframe="true" sandbox="allow-forms allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation-by-user-activation" data-google-container-id="3" data-load-complete="true" style="margin: 0px; padding: 0px; border-width: 0px; border-style: initial; vertical-align: bottom;"></iframe></div></div></div><div class="boxed" style="margin: 10px 28.7969px; padding: 0px; clear: both;"><div id="lipsum" style="margin: 0px; padding: 0px; text-align: justify;"><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ultricies, turpis quis sagittis iaculis, orci ligula fringilla augue, non tincidunt est nisi vel elit. Nulla pharetra leo ut egestas suscipit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris sem justo, auctor sit amet dapibus ut, malesuada sagittis ligula. Cras venenatis quam ligula, sit amet imperdiet arcu dignissim ut. Nunc sit amet ligula urna. Nullam consequat quis neque sed porta. Quisque at interdum lacus.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;">Aenean vitae dui id quam vehicula malesuada. Fusce purus lacus, sodales vitae feugiat eu, gravida vitae ipsum. Mauris non lacus arcu. Mauris congue magna quam, vitae faucibus velit malesuada nec. Proin ligula magna, egestas in condimentum a, finibus ut nisi. Nulla vel sapien metus. Integer ac odio ut leo auctor eleifend vel a ex. Proin sagittis, quam quis convallis cursus, velit lorem lacinia ex, et vulputate nisi felis a massa. Sed ut lectus ac nulla placerat pretium. Suspendisse ultricies, massa quis fermentum rhoncus, lorem justo auctor nisi, in scelerisque dolor urna sed lectus. Integer ac tortor at tortor ultricies tempus non vitae sem. Nam et turpis eu ante egestas egestas at quis risus. Praesent imperdiet hendrerit est non hendrerit.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;">Nunc lorem ex, feugiat nec facilisis ac, aliquam nec felis. Morbi vitae justo ut ex scelerisque posuere ullamcorper sed ipsum. Cras posuere lorem vitae augue efficitur vehicula. Duis scelerisque maximus erat sit amet rutrum. Cras arcu elit, imperdiet ac convallis at, mollis quis orci. Vestibulum eget ullamcorper urna. Donec molestie diam et urna viverra pellentesque. Donec tincidunt egestas purus condimentum ultrices. Ut eu eros cursus, dictum erat vel, tempor velit. Aenean finibus id mi non dignissim. In pharetra a turpis vel ullamcorper. Fusce viverra mi dui, non tristique metus tempus nec. Duis tempor consectetur metus nec ornare. In hac habitasse platea dictumst. Cras varius lobortis viverra.</p></div></div></div>',
                        'banner' => 1,
                        'meta_title' => 'Debitis dolor sed ma',
                        'meta_img' => NULL,
                        'meta_description' => 'Qui laborum Accusan',
                        'meta_keywords' => 'Consectetur voluptat',
                        'status' => 1,
                        'created_at' => '2021-04-08 12:26:19',
                        'updated_at' => '2021-04-08 12:27:13',
                        'deleted_at' => NULL,
                        'user_id' => 1,
                        'estimated_time' => NULL,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'category_id' => 1,
                        'title' => 'Some Blog Post',
                        'slug' => 'some-blog-post',
                        'short_description' => 'wwwwwww',
                        'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&nbsp; &nbsp;<br></p>',
                        'banner' => NULL,
                        'meta_title' => 'www',
                        'meta_img' => NULL,
                        'meta_description' => 'www',
                        'meta_keywords' => 'ww',
                        'status' => 1,
                        'created_at' => '2021-05-10 11:41:25',
                        'updated_at' => '2021-05-13 07:21:22',
                        'deleted_at' => NULL,
                        'user_id' => 2,
                        'estimated_time' => 5.0,
                    ),
            ));
        }

    }
}
