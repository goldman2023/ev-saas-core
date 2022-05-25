<?php

namespace App\Nova\Tenant;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\URL;
use Laravel\Nova\Fields\Image;
use Eminiarts\Tabs\Traits\HasTabs;
use Eminiarts\Tabs\Tabs;

class Product extends Resource
{
    use HasTabs;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [


            MorphMany::make('Activity', 'activities'),
            HasOne::make('Shop'),
            HasOne::make('User'),
            new Tabs('Some Title', [
                'General'    => [
                    Image::make('Thumbnail')
                        ->disk('s3')
                        ->thumbnail(function ($value, $disk) {
                            return $this->getThumbnail(['w' => 100]);
                        })->preview(function ($value, $disk) {
                            return $this->getThumbnail(['w' => 100]);
                        }),
                    Text::make('Name'),
                    Text::make('Permalink', function () {
                        return $this->getPermalink();
                    })->hideFromIndex(),
                    Text::make('Views', function () {
                        return $this->public_view_count() . '/' . $this->public_view_count();
                    }),


                    Heading::make('Shipping'),
                ],
                'Media'    => [
                    Image::make('Thumbnail')
                        ->disk('s3')
                        ->preview(function ($value, $disk) {
                            return $this->getThumbnail();
                        })->hideFromIndex(),
                    Image::make('Cover')
                        ->disk('s3')
                        ->preview(function ($value, $disk) {
                            return $this->getCover();
                        })->hideFromIndex(),
                ],
                'Shipping' => [
                    Boolean::make('Shippable', function () {
                        return $this->isShippable();
                    }),
                ],
                'Advanced' => [
                    Heading::make('Price'),
                    Text::make('Base Price', function () {
                        return $this->getBasePrice(true);
                    })->sortable(),


                    Select::make('Status'),

                    ID::make()->sortable(),
                ]
            ])
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return false;
    }
}
