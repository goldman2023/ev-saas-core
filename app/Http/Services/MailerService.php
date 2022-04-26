<?php

namespace App\Http\Services;

use App\Http\Services\Integrations\MailerLite;
use App\Models\CategoryRelationship;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopDomain;
use Cache;
use EVS;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use Session;

class MailerService
{
    public $mailerlite;

    public function __construct($app)
    {
        $this->mailerlite = new MailerLite(); // init mailerlite client
    }

    public function mailerlite() {
        return $this->mailerlite;
    }

    
}
