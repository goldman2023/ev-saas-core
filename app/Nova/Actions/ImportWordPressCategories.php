<?php

namespace App\Nova\Actions;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Http\Services\Integrations\WordPressAPIService;

class ImportWordPressCategories extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Import From WordPress';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if(get_tenant_setting('wordpress_api_enabled') && !empty(get_tenant_setting('wordpress_api_route'))) {
            $wp = new WordPressAPIService();
            $page = 1;
            $total_pages = 1;
            $res = null;
    
            $all_categories = [];
    
            do {
                $res = $wp->getCategories($page);
                $total_pages = $res['total_pages'] ?? null;
                $page++;
    
                $data = $res['data'] ?? [];
                $all_categories = array_merge($all_categories, $data);
                
                if(!empty($data)) {
                    foreach($data as $key => $category) {
                        $new_category = Category::updateOrCreate(
                            [
                                'slug' => $category['slug'],
                            ],
                            [
                                'parent_id' => null,
                                'level' => 0,
                                'name' => $category['name'],
                                'description' => $category['description'],
                            ]
                        );
    
                        $new_category->slug = $category['slug'];
                        $new_category->save();
                    }
                }
            } while ($page <= $total_pages);
    
            // (IMPORTANT) TODO: Change Parent_id and level of categories on our end!!!
            
            // dd($all_categories);
            return Action::message('Categories impoorted successfully!');
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
