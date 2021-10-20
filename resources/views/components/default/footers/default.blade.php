<!-- ========== FOOTER ========== -->
@if (get_setting('enable_footer_bottom_links') == 'on')
    <x-footer-bottom-links></x-footer-bottom-links>
@endif

<footer class="container space-1">
    <div class="row align-items-md-center text-center">
        <div class="col-md-3 mb-4 mb-md-0">
            <a href="#" aria-label="Front">
                @if (get_setting('header_logo') != null)
                    <img class="lazyload" src="{{ uploaded_asset(get_setting('header_logo')) }}"
                        data-src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ get_site_name() }}"
                        height="44">
                @else
                    <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ get_site_name() }}"
                        height="44">
                @endif
            </a>
        </div>

        <div class="col-sm-7 col-md-6 mb-4 mb-sm-0">
            <!-- Nav List -->
            <ul class="nav nav-sm justify-content-center text-md-center">
                <!-- Home -->
                @if (get_setting('header_menu_labels') != null)


                    @foreach (get_setting('header_menu_labels') as $key => $value)
                        @php
                            $target = '_self';

                        @endphp
                        <li class="position-static">

                            <a id="homeMegaMenu" class="nav-link" target="{{ $target }}"
                                href="{{ get_setting('header_menu_links')[$key] }}">
                                {{ $value }}
                            </a>
                        </li>
                    @endforeach

                @endif


                <!-- End Home -->

                <!-- End Docs -->


            </ul>
            <!-- End Nav List -->
        </div>

        <div class="col-sm-5 col-md-3 text-sm-right">
            <!-- Social Networks -->
            <ul class="list-inline mb-0">
                @if (get_setting('facebook_link') != null)
                    <li class="list-inline-item">
                        <a class="btn btn-sm btn-icon btn-soft-secondary rounded-circle p-2" target="_blank"
                            href="{{ get_setting('facebook_link') }}">
                            {{-- {{ svg('feathericon-facebook') }} --}}
                        </a>
                    </li>
                @endif

                @if (get_setting('twitter_link') != null)
                    <li class="list-inline-item">
                        <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter">
                            {{-- {{ svg('feathericon-twitter') }} --}}
                        </a>
                    </li>
                @endif
                @if (get_setting('instagram_link') != null)
                    <li class="list-inline-item">
                        <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram">
                            {{-- {{ svg('feathericon-instagram') }} --}}
                        </a>
                    </li>
                @endif
                @if (get_setting('youtube_link') != null)
                    <li class="list-inline-item">
                        <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube">
                            {{-- {{ svg('feathericon-youtube') }} --}}
                        </a>
                    </li>
                @endif
                @if (get_setting('linkedin_link') != null)
                    <li class="list-inline-item">
                        <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin">
                            {{-- {{ svg('feathericon-linkedin') }} --}}
                        </a>
                    </li>
                @endif

            </ul>
            <!-- End Social Networks -->
        </div>
    </div>
</footer>
<!-- ========== END FOOTER ========== -->
