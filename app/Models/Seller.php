<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AttributeTrait;
use App\Traits\GalleryTrait;
use App\Traits\ReviewTrait;
use Spatie\SchemaOrg\Schema;
use App\Models\User;

/**
 * App\Models\Seller
 *
 * @property int $id
 * @property int $user_id
 * @property int $verification_status
 * @property string|null $verification_info
 * @property int $cash_on_delivery_status
 * @property int $sslcommerz_status
 * @property int|null $stripe_status
 * @property int $paypal_status
 * @property string|null $paypal_client_id
 * @property string|null $paypal_client_secret
 * @property string|null $ssl_store_id
 * @property string|null $ssl_password
 * @property string|null $stripe_key
 * @property string|null $stripe_secret
 * @property int $instamojo_status
 * @property string|null $instamojo_api_key
 * @property string|null $instamojo_token
 * @property int $razorpay_status
 * @property string|null $razorpay_api_key
 * @property string|null $razorpay_secret
 * @property float $admin_to_pay
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereAdminToPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereCashOnDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereInstamojoApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereInstamojoStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereInstamojoToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller wherePaypalClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller wherePaypalClientSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller wherePaypalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereRazorpayApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereRazorpaySecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereRazorpayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereSslPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereSslStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereSslcommerzStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereStripeKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereStripeSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereStripeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereVerificationInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seller whereVerificationStatus($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    use AttributeTrait;
    use GalleryTrait;
    use ReviewTrait;
    protected $fillable = ['admin_to_pay'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }

  public function get_attribute_label_by_id($id)
  {
    $attribute = $this
      ->attributes()
      ->where('attribute_id', '=', $id)
      ->first();

    if (!$attribute) {
      return false;
    }

    $label = Attribute::where('id', $attribute->attribute_id)->first();
    $custom_properties = json_decode($label->custom_properties);
    if (isset($custom_properties->unit)) {
      $label = $custom_properties->unit;
    } else {
      $label = false;
    }

    return $label;
  }

  public function get_attribute_value_by_id($id)
  {
    $attribute = $this
      ->attributes()
      ->where('attribute_id', '=', $id)
      ->first();


    if (isset($attribute->attribute_value_id)) {
      $value =  AttributeValue::find($attribute->attribute_value_id)->values;
    } else {
      $value = translate('No Data');
    }
    return $value;
  }

  public function get_schema() {
    $default_properties = array();
    $extra_properties = array();
    $sameAs = $this->user->shop->facebook . "," .
              $this->user->shop->google . "," .
              $this->user->shop->twitter . "," .
              $this->user->shop->youtube;

    foreach($this->seo_attributes as $relation) {
      $schema_value = $relation->attributes()->first()->schema_value ? $relation->attributes()->first()->schema_value : $relation->attribute_value->values;
      if ($relation->attributes()->first()->type == 'checkbox') {
        $schema_value = implode(",", $relation->attributes()->first()->attribute_values->pluck('values')->toArray());
      }
      if (in_array($relation->attributes()->first()->name, default_schema_attributes('App\Models\Seller'))) {
        $default_properties[$relation->attributes()->first()->name] = $schema_value;
      }else {        
        $extra_properties[$relation->attributes()->first()->schema_key] = $schema_value;
      }
    }

    $schema = Schema::corporation()
                    ->legalName($this->user->shop->name)
                    ->description($this->user->shop->meta_description)
                    ->image(uploaded_asset($this->user->shop->sliders))
                    ->logo(uploaded_asset($this->user->shop->logo))
                    ->sameAs($sameAs)
                    ->addProperties($extra_properties);
    $postalAddress = Schema::postalAddress()->streetAddress($this->user->shop->address);

    if (isset($default_properties["Website"])) $schema->url($default_properties["Website"]);
    if (isset($default_properties["Contact email"])) $schema->email($default_properties["Contact email"]);
    if (isset($default_properties["Contact phone"])) $schema->telephone($default_properties["Contact phone"]);
    if (isset($default_properties["VAT Code"])) $schema->vatID($default_properties["VAT Code"]);


    if (isset($default_properties["City"])) $postalAddress->addressLocality($default_properties["City"]);
    if (isset($default_properties["Country"])) $postalAddress->addressCountry($default_properties["Country"]);
    if (isset($default_properties["Zipcode"])) $postalAddress->postalCode($default_properties["Zipcode"]);

    $schema->address($postalAddress);

    return $schema;
  }
}
