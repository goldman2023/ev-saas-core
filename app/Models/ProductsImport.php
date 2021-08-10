<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Auth;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Product([
           'name'     => $row['name'],
           'added_by'    => auth()->user()->isSeller() ? 'seller' : 'admin',
           'user_id'    => auth()->user()->isSeller() ? auth()->user()->id : User::where('user_type', 'admin')->first()->id,
           'category_id'    => $row['category_id'],
           'brand_id'    => $row['brand_id'],
           'video_provider'    => $row['video_provider'],
           'video_link'    => $row['video_link'],
           'unit_price'    => $row['unit_price'],
           'purchase_price'    => $row['purchase_price'] == null ? $row['unit_price'] : $row['purchase_price'],
           'unit'    => $row['unit'],
           'current_stock' => $row['current_stock'],
           'meta_title' => $row['meta_title'],
           'meta_description' => $row['meta_description'],
           'colors' => json_encode(array()),
           'choice_options' => json_encode(array()),
           'variations' => json_encode(array()),
           'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $row['slug'])).'-'.Str::random(5),
           'thumbnail_img' => $this->downloadThumbnail($row['thumbnail_img']),
        ]);
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             'unit_price' => function($attribute, $value, $onFailure) {
                  if (!is_numeric($value)) {
                       $onFailure('Unit price is not numeric');
                  }
              }
        ];
    }

    public function downloadThumbnail($url){
        try {
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $filename = 'uploads/all/'.Str::random(5).'.'.$extension;
            $fullpath = 'public/'.$filename;
            $file = file_get_contents($url);
            file_put_contents($fullpath, $file);

            $upload = new Upload;
            $upload->extension = strtolower($extension);

            $upload->file_original_name = $filename;
            $upload->file_name = $filename;
            $upload->user_id = auth()->user()->id;
            $upload->type = "image";
            $upload->file_size = filesize(base_path($fullpath));
            $upload->save();

            return $upload->id;
        } catch (\Exception $e) {
            //dd($e);
        }
        return null;
    }
}
