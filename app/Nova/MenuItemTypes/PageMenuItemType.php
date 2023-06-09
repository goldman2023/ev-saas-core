<?php

namespace App\Nova\MenuItemTypes;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\Text;
use Outl1ne\MenuBuilder\MenuItemTypes\BaseMenuItemType;

class PageMenuItemType extends BaseMenuItemType
{
    public static function getType(): string
    {
        return 'select';
    }

    /**
     * Get the menu link identifier that can be used to tell different custom
     * links apart (ie 'page' or 'product').
     *
     * @return string
     **/
    public static function getIdentifier(): string {
        return 'page';
    }

    /**
     * Get menu link name shown in  a dropdown in CMS when selecting link type
     * ie ('Product Link').
     *
     * @return string
     **/
    public static function getName(): string {
        return 'Page Link';
    }

    /**
     * Get list of options shown in a select dropdown.
     *
     * Should be a map of [key => value, ...], where key is a unique identifier
     * and value is the displayed string.
     *
     * @return array
     **/
    public static function getOptions($locale): array {
        $ttl = 600;
        $pages = Cache::remember('key', $ttl, function () {
            return Page::published()->get()->keyBy('id')->map(fn($item) => $item->name.' (ID: '.$item->id.')')->toArray();
        });

        return $pages;
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
        $page = Page::find($value);
        return 'Page: '.$page->name.' (ID: '.$page->id.')';
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
        $page = Cache::remember('page_'.$value, 600, function () use ($value) {
            return Page::find($value);
        });

        if(!empty($data['query_params'] ?? null)) {
            $href = ($page ?? '#').'?'.$data['query_params'];
        } else {
            $href = $page?->getPermalink() ?? '#';
        }

        return $href;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array An array of fields.
     */
    public static function getFields(): array
    {
        return [
            'query_params' => Text::make('Query Params')
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
            'value' => 'required',
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
