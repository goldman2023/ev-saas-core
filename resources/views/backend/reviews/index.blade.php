@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('Reviews')}}</h1>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row flex-grow-1">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Reviews')}}</h5>

            </div>
            <div class="col-md-6 col-xl-4 ml-auto mr-0">
                <!-- <form class="" id="sort_by_rating" action="{{ route('admin.reviews.index') }}" method="GET">
                    <div class="" style="min-width: 200px;">
                        <select class="form-control aiz-selectpicker" name="rating" id="rating" onchange="filter_by_rating()">
                            <option value="">{{translate('Filter by Rating')}}</option>
                            <option value="rating,desc">{{translate('Rating (High > Low)')}}</option>
                            <option value="rating,asc">{{translate('Rating (Low > High)')}}</option>
                        </select>
                    </div>
                </form> -->
                <form id="sort_by_content_type" action="{{ route('admin.reviews.index') }}" method="GET">
                    <div class="" style="min-width: 200px;">
                        <select class="form-control aiz-selectpicker" name="content_type" id="content_type" onchange="filter_by_content_type()">
                            <option value="all">{{translate('All Reviews')}}</option>
                            <option value="App\Models\Shop" {{$content_type == 'App\Models\Shop' ? 'selected' : ''}}>{{translate('Company Reviews')}}</option>
                            <option value="App\Models\Product" {{$content_type == 'App\Models\Product' ? 'selected' : ''}}>{{translate('Product Reviews')}}</option>
                            <option value="App\Models\Seller" {{$content_type == 'App\Models\Seller' ? 'selected' : ''}}>{{translate('Seller Reviews')}}</option>
                            <option value="App\Models\Events" {{$content_type == 'App\Models\Events' ? 'selected' : ''}}>{{translate('Event Reviews')}}</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Subject name')}}</th>
                    <th data-breakpoints="lg">{{translate('User')}}</th>
                    <th>{{translate('Rating')}}</th>
                    <th data-breakpoints="lg">{{translate('Comment')}}</th>
                    <th data-breakpoints="lg">{{translate('Published')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $key => $review)
                    @php $subject = $review->review_relationship->reviewable; @endphp
                    <tr>
                        <td>{{ ($key+1) + ($reviews->currentPage() - 1)*$reviews->perPage() }}</td>
                        <td>
                            <a href="{{route('shop.visit', $subject->slug)}}" target="_blank" class="text-reset text-truncate-2">{{ $subject->name }}</a>
                        </td>
                        <td>{{ $review->review_relationship->creator->name }} ({{ $review->review_relationship->creator->email }})</td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ $review->comment }}</td>
                        <td><label class="aiz-switch aiz-switch-success mb-0">
                            <input onchange="update_published(this)" value="{{ $review->id }}" type="checkbox" <?php if($review->status == 1) echo "checked";?> >
                            <span class="slider round"></span></label>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $reviews->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.reviews.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Published reviews updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function filter_by_rating(el){
            var rating = $('#rating').val();
            if (rating != '') {
                $('#sort_by_rating').submit();
            }
        }
        function filter_by_content_type(el) {
            $('#sort_by_content_type').submit();
        }
    </script>
@endsection
