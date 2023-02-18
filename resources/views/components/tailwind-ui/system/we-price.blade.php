@if($model->isDiscounted())
    <div class="flex gap-x-2 justify-center">
        <del class="text-14 text-gray-500">{{ \FX::formatPrice($model->purchase_quantity * $model->getOriginalPrice()) }}</del>
        <strong class="text-14 text-gray-900">{{ \FX::formatPrice($model->purchase_quantity * $model->getDiscountedPrice()) }}</strong>
    </div>
@else
    <strong class="text-14 text-gray-900">{{ \FX::formatPrice($model->purchase_quantity * $model->total_price) }}</strong>
@endif
