<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AttributeTrait;
use App\Traits\GalleryTrait;
use App\Traits\ReviewTrait;
use App\Models\User;
use App\Models\Upload;
use App;
use Spatie\SchemaOrg\Schema;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;
    use ReviewTrait;
    use TranslationTrait;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_attribute_label_by_id($id)
    {
        $attribute = $this->attributes()
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
        $attribute = $this->attributes()
                    ->where('attribute_id', '=', $id)
                    ->first();

        if (isset($attribute->attribute_value_id)) {
             $value =  AttributeValue::find($attribute->attribute_value_id)->values;
        } else {
            $value = translate('No Data');
        }

        if (is_numeric($value)) {
        $value = number_format($value, 2, '.', ',');
        }

        return $value;
    }

    public function get_schema() {
        $default_properties = array();
        $extra_properties = array();

        foreach($this->seo_attributes as $relation) {
            $schema_value = $relation->attributes()->first()->schema_value ? $relation->attributes()->first()->schema_value : $relation->attribute_value->values;
            if ($relation->attributes()->first()->type == 'checkbox') {
                $schema_value = implode(",", $relation->attributes()->first()->attribute_values->pluck('values')->toArray());
            }
            if (in_array($relation->attributes()->first()->name, default_schema_attributes('App\Models\Event'))) {
                $default_properties[$relation->attributes()->first()->name] = $schema_value;
            }else {
                $extra_properties[$relation->attributes()->first()->schema_key] = $schema_value;
            }
        }

        $schema = Schema::event()
                        ->name($this->title)
                        ->description($this->description)
                        ->eventStatus('https://schema.org/EventScheduled')
                        ->image(uploaded_asset($this->upload_id))
                        ->addProperties($extra_properties);

        if (isset($default_properties["Start Date"])) $schema->startDate($default_properties["Start Date"]);
        if (isset($default_properties["End Date"])) $schema->endDate($default_properties["End Date"]);
        if (isset($default_properties["Event type"]) && $default_properties["Event type"] == "Online")
            $schema->eventAttendanceMode('https://schema.org/OnlineEventAttendanceMode');
        else
            $schema->eventAttendanceMode('https://schema.org/OfflineEventAttendanceMode');

        // location schema attributes
        if (isset($default_properties["Event type"]) && $default_properties["Event type"] == "Online"){
            $location = Schema::virtualLocation();
            if (isset($default_properties["JoinURL"])) $location->url($default_properties["JoinURL"]);
        }
        else {
            $location = Schema::place();
            if (isset($default_properties["Location name"])) $schema->name($default_properties["Location name"]);
            $postalAddress = Schema::postalAddress();
            if (isset($default_properties["Location address"])) $postalAddress->streetAddress($default_properties["Location address"]);
            if (isset($default_properties["Location city"])) $postalAddress->addressLocality($default_properties["Location city"]);
            if (isset($default_properties["Location country"])) $postalAddress->addressCountry($default_properties["Location country"]);
            if (isset($default_properties["Location zip code"])) $postalAddress->postalCode($default_properties["Location zip code"]);
            $location->address($postalAddress);
        }
        $schema->location($location);

        // offer schema attributes
        $offers = Schema::offer();
        $offers->url('https://www.example.com/event_offer/12345_201803180430');
        if (isset($default_properties["Price"])) $offers->price($default_properties["Price"]);
        $offers->priceCurrency(\App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code);
        $schema->offers($offers);

        // performer schema attributes
        $performer = isset($default_properties["Performer type"]) && $default_properties["Performer type"] == "Group" ? Schema::performingGroup() : Schema::person();
        if (isset($default_properties["Performer name"])) $performer->name($default_properties["Performer name"]);
        $schema->performer($performer);

        // organizer schema attributes
        $organizer = Schema::organization()
                            ->name($this->user->shop->name)
                            ->url(env('APP_URL') . '/shop/' . $this->user->shop->slug);
        $schema->organizer($organizer);

        return $schema;
    }

    public function getTranslationModel(): ?string
    {
        return EventTranslation::class;
    }
}
