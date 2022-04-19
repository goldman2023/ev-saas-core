<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;
use Storage;
use IMG;
use MediaService;
use FroalaEditor_Image;

class WeMediaController extends Controller
{
    public function froalaLoadImages(Request $request) {
        dd('teeet');
    }

    public function froalaImageUpload(Request $request) {
        $options = array(
            'validation' => array(
              'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'webp'),
              'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml', 'image/webp')
            )
          );

        try { 
            // 1. Upload image to temp folder (public/images) and get miage info
            $response = FroalaEditor_Image::upload('/images/', $options);
            
            $new_image_content = file_get_contents($_SERVER['DOCUMENT_ROOT'].$response->link);
            $new_image_name = time() . '_' . basename($response->link);
            $new_image_extension = $file_ext = pathinfo($new_image_name, PATHINFO_EXTENSION);
            $new_image_filesize = strlen($new_image_content);

            // 2. Store image to our S3 Do bucket
            $tenant_path = 'uploads/all';

            if(tenant('id')) {
                $tenant_path = 'uploads/'.tenant('id');
            }            

            // Check if tenant uploads folder exists an create it if not
            if(!Storage::exists($tenant_path)){
                // Create Tenant folder on DO if it doesn't exist
                Storage::makeDirectory($tenant_path, 0775, true, true);
            }

            $s3_image_path = $tenant_path.'/'.$new_image_name;
            Storage::put($s3_image_path, $new_image_content, 'public');

            // 3. Create Upload record in our DB
            $upload = new Upload();
            $upload->extension = $new_image_extension;
            $upload->file_name = $s3_image_path;
            $upload->user_id = auth()->user()->id;
            $upload->shop_id = empty(MyShop::getShopID()) ? null : MyShop::getShopID();
            $upload->type = MediaService::getPermittedExtensions()[$new_image_extension] ?? '';
            $upload->file_size = $new_image_filesize;
            $upload->save();

            // 4. Remove image from public/images (temp)
            unlink($_SERVER['DOCUMENT_ROOT'].$response->link);

            // 5. Return optimized image through IMGProxy!!! (webp version)
            echo stripslashes(json_encode(['link' => IMG::get($upload->file_name) ]));
            die();
        }
        catch (Exception $e) {
            http_response_code(404);
        }
    }
}
