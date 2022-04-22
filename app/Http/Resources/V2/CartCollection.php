<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'seller_id' => $data->seller_id,
                    'product' => [
                        'name' => $data->product->name,
                        'image' => api_asset($data->product->thumbnail_img),
                    ],
                    'variation' => $data->variation,
                    'price' => (float) $data->price,
                    'tax' => (float) $data->tax,
                    'shipping_cost' => (float) $data->shipping_cost,
                    'quantity' => (int) $data->quantity,
                    'date' => $data->created_at->diffForHumans(),
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
}
