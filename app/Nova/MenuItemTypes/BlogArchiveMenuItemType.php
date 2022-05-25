<?php

namespace App\Nova\MenuItemTypes;

use App\Models\Page;
use App\Models\Category;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Outl1ne\MenuBuilder\MenuItemTypes\BaseMenuItemType;
use Categories;

class BlogArchiveMenuItemType extends BaseMenuItemType
{
    public static function getType(): string
    {
        return 'text';
    }

    /**
     * Get the menu link identifier that can be used to tell different custom
     * links apart (ie 'page' or 'product').
     *
     * @return string
     **/
    public static function getIdentifier(): string {
        return 'blog-archive';
    }

    /**
     * Get menu link name shown in  a dropdown in CMS when selecting link type
     * ie ('Product Link').
     *
     * @return string
     **/
    public static function getName(): string {
        return 'Blog Archive';
    }

    /**
     * Get the subtitle value shown in CMS menu items list.
     *
     * @param $value
     * @param $data The data from item fields.
     * @param $locale
     * @return string
     **/
    public static function getDisplayValue($value, ?array $data, $locale) {
        if(($data['from_specific_category'] ?? null) && $data['from_specific_category'] !== 'all') {
            $category = Categories::getByID($data['from_specific_category']);

            return 'Blog Archive (Category: '.$category->name.')';
        }
        return 'Blog Archive';
    }

    /**
     * Get the value of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param $value The key from options list that was selected.
     * @param $data The data from item fields.
     * @param $locale
     * @return any
     */
    public static function getValue($value, ?array $data, $locale)
    {
        if(($data['from_specific_category'] ?? null) && $data['from_specific_category'] !== 'all') {
            $category = Categories::getByID($data['from_specific_category']);

            if(!empty($category)) {
                return route('blog.category.archive', ['category_slug' => $category->slug]);
            }
        }
        return route('blog.archive');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array An array of fields.
     */
    public static function getFields(): array
    {
        $all_categories = Categories::getAll(true)->keyBy('id')->map(fn($item) => str_repeat('-', $item->level).$item->name)->toArray();

        return [
            Select::make('From Specific Category')->options([
                'all' => translate('All'),
            ] + $all_categories)
        ];
    }

    /**
     * Get the rules for the resource.
     *
     * @return array A key-value map of attributes and rules.
     */
    public static function getRules(): array
    {
        return [
            // 'value' => 'required',
        ];
    }

    /**
     * Get data of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param null $data Field values
     * @return any
     */
    public static function getData($data = null)
    {
        return $data;
    }
}