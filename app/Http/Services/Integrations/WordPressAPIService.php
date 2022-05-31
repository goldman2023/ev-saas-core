<?php

namespace App\Http\Services\Integrations;

use Illuminate\Support\Facades\Http;
use App\Models\Category;
use Illuminate\Support\Facades\Request;

class WordPressAPIService
{
    public $wp;
    public $route;

    public function __construct()
    {
        $this->route = rtrim(get_tenant_setting('wordpress_api_route'), '/');
    }

    public function getCategories($page = 1) {
        $res = Http::get($this->route.'/categories', [
            '_fields' => 'id,name,parent,slug,description,meta',
            'per_page' => 5,
            'page' => $page
        ]);

        $data = $res->json();
        $total_items = $res->header('x-wp-total');
        $total_pages = $res->header('x-wp-totalpages');

        return [
            'data' => $data,
            'total_items' => (int) $total_items,
            'total_pages' => (int) $total_pages,
        ];
    }

    public function getBlogPosts($page = 1, $per_age = 10) {
        $res = Http::get($this->route.'/posts', [
            '_fields' => 'id,date,modified,slug,status,type,featured_media,title,content,excerpt,categories,yoast_head_json',
            'per_page' => $per_age,
            'page' => $page
        ]);

        $data = $res->json();
        $total_items = $res->header('x-wp-total');
        $total_pages = $res->header('x-wp-totalpages');

        return [
            'data' => $data,
            'total_items' => (int) $total_items,
            'total_pages' => (int) $total_pages,
        ];
    }

    public function getCustomPostType($base = null, $page = 1, $per_age = 10) {
        if(empty($base))
            return null;

        $res = Http::get($this->route.'/'.$base, [
            '_fields' => 'id,date,modified,slug,status,type,featured_media,title,content,excerpt,categories,yoast_head_json',
            'per_page' => $per_age,
            'page' => $page
        ]);

        $data = $res->json();
        $total_items = $res->header('x-wp-total');
        $total_pages = $res->header('x-wp-totalpages');

        return [
            'data' => $data,
            'total_items' => (int) $total_items,
            'total_pages' => (int) $total_pages,
        ];
    }


    public function getCategoriesByIDs($categories_ids) {
        if(empty($categories_ids))
            return [];

        $res = Http::get($this->route.'/categories', [
            'include' => implode(',', $categories_ids),
            'per_page' => 100
        ]);

        $data = $res->json();
        $total_items = $res->header('x-wp-total');
        $total_pages = $res->header('x-wp-totalpages');

        return [
            'data' => $data,
            'total_items' => (int) $total_items,
            'total_pages' => (int) $total_pages,
        ];
    }

    public function getMediaByID($media_id) {
        if(empty($media_id))
            return [];

        $res = Http::get($this->route.'/media/'.$media_id, [
            '_fields' => 'media_details',
        ]);

        $data = $res->json();

        return [
            'data' => $data,
        ];
    }
}
