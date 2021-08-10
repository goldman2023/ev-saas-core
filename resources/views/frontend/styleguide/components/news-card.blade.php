<div class="b2b-component space-2">
    <div class="col-12">
        <h1 class="b2b-component__heading">News Card (News Page)</h1>
        @php
            $item = App\Models\Blog::first();
        @endphp
        <div class="row">
            <div class="col-sm-4">
                <x-news-card :item="$item"></x-news-card>
            </div>
        </div>
    </div>
</div>
