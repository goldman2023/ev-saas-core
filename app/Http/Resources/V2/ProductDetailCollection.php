<?php

namespace App\Http\Resources\V2;

use App\Models\Attribute;
use App\Models\Review;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'name' => $data->name,
                    'added_by' => $data->added_by,
                    'seller_id' => $data->user->id,
                    'shop_id' => $data->added_by == 'admin' ? 0 : $data->user->shop->id,
                    'shop_name' => $data->added_by == 'admin' ? 'In House Product' : $data->user->shop->name,
                    'shop_logo' => $data->added_by == 'admin' ? api_asset(get_setting('header_logo')) : api_asset($data->user->shop->logo),
                    'photos' => get_images_path($data->photos),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'tags' => explode(',', $data->tags),
                    'price_high_low' => (float) explode('-', homeDiscountedPrice($data->id))[0] == (float) explode('-', homeDiscountedPrice($data->id))[1] ? format_price((float) explode('-', homeDiscountedPrice($data->id))[0]) : 'From '.format_price((float) explode('-', homeDiscountedPrice($data->id))[0]).' to '.format_price((float) explode('-', homeDiscountedPrice($data->id))[1]),
                    'choice_options' => $this->convertToChoiceOptions(json_decode($data->choice_options)),
                    'colors' => json_decode($data->colors),
                    'has_discount' => homeBasePrice($data->id) != homeDiscountedBasePrice($data->id),
                    'stroked_price' => home_base_price($data->id),
                    'main_price' => home_discounted_base_price($data->id),
                    'calculable_price' => (float) homeDiscountedBasePrice($data->id),
                    'currency_symbol' => currency_symbol(),
                    'current_stock' => (int) $data->current_stock,
                    'unit' => $data->unit,
                    'rating' => (float) $data->rating,
                    'rating_count' => (int) Review::where(['product_id' => $data->id])->count(),
                    'earn_point' => (float) $data->earn_point,
                    'description' => $data->description,
                ];
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200,
        ];
    }

    protected function convertToChoiceOptions($data)
    {
        $result = [];
        foreach ($data as $key => $choice) {
            $item['name'] = $choice->attribute_id;
            $item['title'] = Attribute::find($choice->attribute_id)->name;
            $item['options'] = $choice->values;
            array_push($result, $item);
        }

        return $result;
    }

    protected function convertPhotos($data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }

        return $result;
    }
}
