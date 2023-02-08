<?php

namespace App\Nova\Tenant;

use App\Models\Currency as ModelsCurrency;
use App\Nova\Resource;
use App\View\Components\EV\Form\Checkbox;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource as NovaResource;
use Nium\Currencies\Currencies;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class Currency extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ModelsCurrency::class;

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

            Stack::make('Details', [
                Text::make(__('Symbol'), 'symbol')->required(true),
                Text::make(__('Code'), 'code')->required(true),
            ]),

            Boolean::make(__('Payout via ACH'), 'code'),
            Boolean::make(__('Payout via ACH'), 'code'),
            Boolean::make(__('Payout via VISA'), 'code'),
            Boolean::make(__('Cashouts'), 'code'),
            Boolean::make(__('Wallets'), 'code'),
            Boolean::make(__('USD Wires'), 'code')->help(
                '(Citi)'
            ),
            Boolean::make(__('Foreign Currency WIRES Global'), 'code')->help(
                'The tax rate to be applied to the sale'
            ),
            Boolean::make(__('Foreign Currency WIRES EUR'), 'code')->help(
                'EUR'
            ),
            BooleanGroup::make('Payout via WIRES')->options([
                'yes' => 'Yes',
                'no' => 'No',
                'yes_conditions' => 'Yes, conditions apply',
            ]),

            BooleanGroup::make('Real-time via')->options([
                'ACH' => 'ACH',
                'VISA' => 'VISA',
                'Proxy' => 'Proxy',
            ]),

            BooleanGroup::make('Payment Types')->options([
                'b2b' => 'B2B',
                'b2c' => 'B2C',
                'p2p' => 'P2P',
            ])->required(true),

            Select::make('Proxy')->options([
                'domestic' => 'Domestic',
                'yes' => 'Yes',
                'no' => 'No',
            ]),

            Select::make('Continent')->options([
                'africa' => 'Africa',
                'asia' => 'Asia',
                'Oceania' => 'Oceania',
                'south_america' => 'Souh America',
                'north_america' => 'North America',
                'europe' => 'Europe',
            ]),

            Boolean::make(__('Delivery Time'), 'created_at')->help('(subject to cutoff)'),

            (new Panel('Continent', [
                Textarea::make(__('Notes'), 'notes'),
                Textarea::make(__('Supporting documents'), 'supporting_documents'),
                Textarea::make(__('Proof of payment'), 'proof_of_payment'),
            ]))->limit(1),

            (new Panel('Exra details', [
                Text::make('API Endpoint', function () {
                    return 'https://api.playbook.nium.com/currencies/inr';
                })->asHtml()->onlyOnDetail(),
                DateTime::make(__('Created At'), 'created_at')->onlyOnDetail(),
                ID::make()->sortable()->onlyOnDetail(),
            ]))->limit(1),




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
        return [new Currencies];
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
