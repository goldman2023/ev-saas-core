@if (!is_null($banners))
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @foreach ($banners as $banner)
                    <div class="mb-4">
                        <div class="container">
                            <div class="row gutters-10">
                                <div class="col-xl col-md-6">
                                    <x-affiliate-single-banner :banner="$banner"> </x-affiliate-single-banner>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endif
@section('script')
    <script>
        $(".b2b-banner a").on('click', function(e) {
            e.preventDefault();
            let banner_url = $(this).attr('data-banner-url');
            window.location.href = banner_url;
        })

    </script>
@endsection
