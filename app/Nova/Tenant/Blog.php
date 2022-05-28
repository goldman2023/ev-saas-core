<?php

namespace App\Nova\Tenant;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;

class Blog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BlogPost::class;

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
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Image::make('Thumbnail')
                ->disk('s3')
                ->preview(function ($value, $disk) {
                    return $this->getThumbnail();
                }),

                Image::make('Cover')
                ->disk('s3')
                ->preview(function ($value, $disk) {
                    return $this->getCover();
                }),


            Text::make('Name'),


            Heading::make('Details'),
            Select::make('Status', function () {
                return $this->status;
            }),



            Text::make('Name'),
            Textarea::make('Content'),
            MorphMany::make('Activity', 'activities'),

            ID::make()->sortable(),
            // BelongsTo::make('Author', 'author', User::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new \App\Nova\Actions\ImportWordPressBlogPosts())->standalone()
        ];
    }
}
