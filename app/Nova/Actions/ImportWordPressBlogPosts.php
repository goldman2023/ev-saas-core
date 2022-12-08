<?php

namespace App\Nova\Actions;

use DB;
use Log;
use Storage;
use MediaService;
use App\Models\Upload;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use App\Models\CategoryRelationship;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Http\Services\Integrations\WordPressAPIService;

class ImportWordPressBlogPosts extends Action 
{
    use InteractsWithQueue, Queueable;

    public $name = 'Import From WordPress';
    public $initiator;
    public $wp;

    public function __construct($initiator)
    {
        $this->initiator = $initiator;
        $this->wp = new WordPressAPIService();
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        set_time_limit(1000);
        if(get_tenant_setting('wordpress_api_enabled') && !empty(get_tenant_setting('wordpress_api_route'))) {
            $page = 1;
            $total_pages = 1;
            $res = null;

            $self = $this;
            
            
            Log::info('---------- Starting WP Posts import ----------');

            do {
                $res = $this->wp->getBlogPosts($page, 20);
                $total_pages = $res['total_pages'] ?? null;

                Log::info('Page: '.$page);
                Log::info('Total pages: '.$total_pages);

                $page++;

                $data = $res['data'] ?? [];

                Log::info(collect($data)->pluck('id')->toArray());
                
                if(!empty($data)) {
                    foreach($data as $key => $blogPost) {
                        if(!empty($blogPost['slug'] ?? '')) {
                            dispatch(function () use ($blogPost) {
                                $this->importBlogPost($blogPost);
                            });
                        }
                    }
                }
            } while ($page <= $total_pages);
    
            Log::info('---------- Ending WP Posts import ----------');

            do_action('import.wordpress.blog-posts.end', [$this->wp, $this]);

            return Action::message('Blog Posts imported successfully!');
        }
    }

    public function importBlogPost($blogPost) {
        DB::beginTransaction();
        try {
            $new_blog_post = BlogPost::where([
                ['slug', $blogPost['slug']],
                ['shop_id', 1],
                ['type', 'blog'],
            ])->first();
            $already_exists = true;

            if(empty($new_blog_post)) {
                $new_blog_post = new BlogPost();
                $already_exists = false;
            }

            $new_blog_post->forceFill(array_merge([
                    'slug' => $blogPost['slug'],
                    'shop_id' => 1,
                    'type' => 'blog',
                ],
                [
                    'user_id' => $this->initiator->id,
                    'status' => $blogPost['status'] === 'publish' ? 'published' : $blogPost['status'],
                    'name' => html_entity_decode($blogPost['title']['rendered'] ?? ''),
                    'excerpt' => html_entity_decode(strip_tags($blogPost['excerpt']['rendered'] ?? '')),
                    'content' => $blogPost['content']['rendered'] ?? '',
                    'meta_title' => html_entity_decode($blogPost['yoast_head_json']['title'] ?? ''),
                    'meta_description' => html_entity_decode(strip_tags($blogPost['yoast_head_json']['description'] ?? '')),
                    'created_at' => $blogPost['date'],
                    'updated_at' => $blogPost['modified'],
                ]));

            $new_blog_post->slug = $blogPost['slug'];
            $new_blog_post->created_at = $blogPost['date'];
            $new_blog_post->updated_at = $blogPost['modified'];
            $new_blog_post->save();

            // Add authors
            // Importer is the author for now
            DB::table('blog_post_relationships')->upsert([
                [
                    'subject_type' => $this->initiator::class, 
                    'subject_id' => $this->initiator->id, 
                    'blog_post_id' => $new_blog_post->id, 
                    'created_at' => date("Y-m-d H:i:s", time()), 
                    'updated_at' => date("Y-m-d H:i:s", time()), 
                ],
            ], ['subject_type', 'subject_id', 'blog_post_id'], ['subject_type', 'subject_id', 'blog_post_id', 'created_at', 'updated_at']);

            // Add Categories
            $categories = $this->wp->getCategoriesByIDs($blogPost['categories'] ?? []);
            if(!empty($categories) && !empty($categories['data'] ?? null)) {
                $categories_idx = collect($categories['data'])->map(fn($item) => Category::where('slug', $item['slug'])->first())->filter()->pluck('id')->toArray();
                
                foreach($categories_idx as $category_id) {
                    CategoryRelationship::updateOrCreate([
                        'subject_type' => $new_blog_post::class,
                        'subject_id' => $new_blog_post->id,
                        'category_id' => $category_id
                    ],[]);
                }
            }

            // Add Thumbnail and Cover (if post was not already imported before)
            if(!$already_exists) {
                $wp_media = $this->wp->getMediaByID($blogPost['featured_media']);

                if(empty($new_blog_post->thumbnail) && !empty($wp_media['data']) && !empty($wp_media['data']['media_details'])) {
                    $source_url = $wp_media['data']['media_details']['sizes']['full']['source_url'] ?? null;
                    $extension = MediaService::mime2ext($wp_media['data']['media_details']['sizes']['full']['mime_type'] ?? null);
    
                    if(!empty($source_url) && isset(MediaService::getPermittedExtensions()[$extension])) {
                        $file_content = file_get_contents($source_url);
                        $file_size = strlen($file_content);
                        $file_name = time().'_'.$wp_media['data']['media_details']['sizes']['full']['file'] ?? null;
    
                        $upload = new Upload();
                        $tenant_path = 'uploads/all';
    
                        if (tenant('id')) {
                            $tenant_path = 'uploads/'.tenant('id');
                        }
    
                        // Check if tenant uploads folder exists an create it if not
                        if (! Storage::exists($tenant_path)) {
                            // Create Tenant folder on DO if it doesn't exist
                            Storage::makeDirectory($tenant_path, 0775, true, true);
                        }
    
                        $s3_image_path = $tenant_path.'/'.$file_name;
                        Storage::put($s3_image_path, $file_content, 'public');
    
                        $upload->extension = $extension;
                        $upload->file_original_name = $wp_media['data']['media_details']['sizes']['full']['file'] ?? '';
                        $upload->file_name = $s3_image_path;
                        $upload->user_id = $this->initiator->id;
                        $upload->shop_id = 1;
                        $upload->type = MediaService::getPermittedExtensions()[$extension];
                        $upload->file_size = $file_size;
                        $upload->save();
    
                        // Sync Uploads with blog post
                        $new_blog_post->thumbnail = $upload->id;
                        $new_blog_post->cover = $upload->id;
                        $new_blog_post->meta_img = $upload->id; // TODO: This one can be taken from Yoast FYI
                        $new_blog_post->syncUploads();
                    }
                }
            }
            
            DB::commit();

            Log::info('(#'.$new_blog_post->id.') '.$new_blog_post->name.' - successfully imported!');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
            return Action::danger('Something went wrong!');
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
