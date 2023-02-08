<?php

namespace App\Nova\Tenant;

use App\Models\Country as ModelsCountry;
use App\Models\Currency as ModelsCurrency;
use App\Nova\Resource;
use App\View\Components\EV\Form\Checkbox;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource as NovaResource;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class Country extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ModelsCountry::class;

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
        'id', 'code', 'name'
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
            Text::make(__('Name'), 'name')->required(true),
            Text::make(__('ID'), 'id'),
            Stack::make('Code', [
                Text::make(__('Code'), 'code')->required(true),
            ]),

            new Tabs(
                'Details',
                [
                    'Payment Capabilities'    => [
                        Boolean::make('ACH', 'ach')->sortable(),
                        Boolean::make('Wire', 'wire_transfers')->sortable(),
                        Boolean::make('Visa Direct', 'visa_direct')->sortable(),
                        Boolean::make('Cash', 'cash')->sortable(),
                        Boolean::make('Wallet', 'wallet')->sortable(),
                        Boolean::make('Local Currency', 'local_currency')->sortable(),
                    ],
                    'Supported Currencies'    => [
                        Boolean::make('USD', 'usd_supported')->onlyOnDetail(),
                        Boolean::make('HKD', 'hkd_supported')->onlyOnDetail(),
                        Boolean::make('SGD', 'sgd_supported')->onlyOnDetail(),
                        Boolean::make('GBP', 'gbp_supported')->onlyOnDetail(),
                        Boolean::make('AUD', 'aud_supported')->onlyOnDetail(),
                        Boolean::make('CAD', 'cad_supported')->onlyOnDetail(),
                        Boolean::make('EUR', 'eur_supported')->onlyOnDetail(),
                    ],
                    'Meta'    => [
                        KeyValue::make('Meta', 'meta')->rules('json'),
                    ],
                ]),



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
        // new Currencies
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
        return [];
    }
}
