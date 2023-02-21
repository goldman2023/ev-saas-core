<?php

namespace App\Http\Services;

use WE;
use Cache;
use Session;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Attribute;
use App\Models\ShopDomain;
use App\Models\AttributeValue;
use App\Models\CategoryRelationship;
use Illuminate\Support\Facades\Request;
use Illuminate\Notifications\Notification;
use Illuminate\View\ComponentAttributeBag;
use App\Http\Services\Integrations\MailerLite;

class MailerService
{
    public $app;
    public $mailerlite;

    public function __construct($app)
    {
        $this->app = $app();

        $this->mailerlite = new MailerLite(); // init mailerlite client (if integration is enabled)
    }

    public function mailerlite() {
        return $this->mailerlite;
    }

    public function notify($notifiable, $notification) {
        if(method_exists($notifiable, 'notify') && $notification instanceof Notification) {
            $notifiable->notify($notification);
        }
    }
}
