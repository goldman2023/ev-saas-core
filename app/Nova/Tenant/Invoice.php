<?php

namespace App\Nova\Tenant;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Invoice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Invoice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Email')->required(),
            Text::make('Invoice Number')->required(),
            Number::make('Total Price')->required(),
            Text::make('Payment Status')->required(),
            BelongsTo::make('User', 'user', 'App\Nova\Tenant\User'),
            BelongsTo::make('Order', 'order', 'App\Nova\Tenant\Order')->hideFromIndex(),
            BelongsTo::make('Shop', 'shop', 'App\Nova\Tenant\Shop')->hideFromIndex(),
            MorphTo::make('Payment Method', 'payment_method', PaymentMethodUniversal::class),

            new Tabs(
                'Some Title',
                [
                    'Billing Information'    => [
                        Text::make('Billing First Name')->required()->hideFromIndex(),
                        Text::make('Billing Last Name')->required()->hideFromIndex(),
                        Text::make('Billing Company')->hideFromIndex(),
                        Text::make('Billing Address')->required()->hideFromIndex(),
                        Text::make('Billing Country')->required()->hideFromIndex(),
                        Text::make('Billing City')->required()->hideFromIndex(),
                        Text::make('Billing ZIP')->required()->hideFromIndex(),
                        Text::make('Billing State')->required()->hideFromIndex(),

                    ],
                    'Shipping Information'    => [
                        Text::make('Billing Country')->required(),
                        Number::make('Shipping cost'),

                    ],
                    'Price & Tax Breakdown'    => [
                        Text::make('Payment Status')->required(),
                        Number::make('Base Price')->required(),
                        Number::make('Discount Amount')->required(),
                        Number::make('Subtotal Price')->required(),
                        Number::make('Tax')->required(),
                        Number::make('Total Price')->required(),


                    ],
                    'Other'    => [
                        Boolean::make('Viewed by customer')->required(),
                        Boolean::make('Is temporary', 'is_temp')->required(),
                        DateTime::make('Created at')->required(),
                        DateTime::make('Updated at')->required(),

                    ]
                ]
            )
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
}
