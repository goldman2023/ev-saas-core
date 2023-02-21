@if($model->isDiscounted())
    <div class="flex gap-x-2 justify-center {{ $class }}">
        <del class="text-14 text-gray-500">{{ $base_price }}</del>
        <strong class="text-14 text-gray-900">{{ $total_price }}</strong>
    </div>
@else
    <strong class="text-14 text-gray-900 {{ $class }}">{{ $total_price }}</strong>
@endif
