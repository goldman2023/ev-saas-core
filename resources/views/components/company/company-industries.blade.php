<h6 class="mb-0 b2b-company-industries-list">
    @if (count($company->categories) > 0)
        {{ translate('Company Industries: ') }}
        @foreach ($company->categories as $category)
            <a class="text-dark" href="{{ route('companies.category', $category->slug) }}">
                {{ $category->name }}
            </a>

            @if (!$loop->last)
                /
            @endif
        @endforeach

    @else
        {{ translate('Data Incomplete') }}
    @endif

    {{-- {{ $company->meta_title }} --}}
    </a>
</h6>
