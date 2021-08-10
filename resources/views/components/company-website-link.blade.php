@if ($company->get_company_website_url())
    @if($company->get_company_website_url()["href"]!='No Data')
        <a href="{{ qs_url($company->get_company_website_url()['href'],['utm_source' => 'b2bwood']) }}"
           data-company-website="{{ route('website_clicks.track', encrypt($company->id)) }}" target="_blank">
            {{ $company->get_company_website_url()['href'] }}
        </a>
    @elseif($company->get_company_website_url()["href"]=='No Data')
        {{ $company->get_company_website_url()['href'] }}
    @endif
@endif
@if ($company->get_company_website_url()['href'] != 'No Data')
@section('script')
    <script>
        $(".b2b-company-website-link a").on('click', function (e) {
            e.preventDefault();
            let company_website = $(this).attr('data-company-website');
            window.location.href = company_website;
        })

    </script>
@endsection
@endif
