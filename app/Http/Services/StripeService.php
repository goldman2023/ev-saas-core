<?php

namespace App\Http\Services;

use DB;
use FX;
use EVS;
use Log;
use Uuid;
use Cache;
use Carbon;
use Stripe;
use Session;
use Payments;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\CoreMeta;
use App\Models\OrderItem;
use App\Models\Ownership;
use App\Enums\UserTypeEnum;
use App\Models\WeBaseModel;
use App\Enums\OrderTypeEnum;
use App\Facades\CartService;
use Illuminate\Http\Request;
use App\Enums\UserEntityEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Enums\UserSubscriptionStatusEnum;
use App\Http\Services\Stripe\StripeEngine;
use App\Models\UserSubscriptionRelationship;
use Illuminate\Database\Eloquent\Collection;
use Mpociot\VatCalculator\Facades\VatCalculator;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use App\Notifications\Invoice\InvoicePaymentFailed;
use Illuminate\Support\Traits\ForwardsCalls;

class StripeService
{
    use ForwardsCalls;

    public $stripe_engine = null;
    
    public function __construct($app)
    {
        // IMPORTANT: Accessing any service in constructor, like app('stripe_service') - through _call or __get will display 500 error
        // Reason is that stripe_service singleton object is being created here, and if we call app('stripe_service') we are trying to access something which is not yet initiated!
        $this->stripe_engine = new StripeEngine();
    }

    public function __call($method, $arguments)
    {
        // Forward all non-existing functions to StripeEngine
        return $this->forwardCallTo(
            $this->stripe_engine, $method, $arguments
        );
    }

    public function __get(string $key)
    {
        // Forward all non-existing properties to StripeEngine
        return $this->stripe_engine->{$key};
    }
}
