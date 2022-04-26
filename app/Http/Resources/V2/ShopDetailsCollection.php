<?php

namespace App\Http\Resources\V2;

use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                $true_rating = Product::where('user_id', $data->user_id)->where('rating', '>', 0.00)->avg('rating');
                $rating = ceiling($true_rating, 0.5);

                return [
                    'id' => $data->id,
                    'user_id' => $data->user_id,
                    'name' => $data->name,
                    'logo' => api_asset($data->logo),
                    'sliders' => get_images_path($data->sliders),
                    'address' => $data->address,
                    'facebook' => $data->facebook,
                    'google' => $data->google,
                    'twitter' => $data->twitter,
                    'true_rating' => $true_rating == null ? 0.00 : $true_rating,
                    'rating' => (float) $rating,
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

    protected function convertPhotos($data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }

        return $result;
    }
}
