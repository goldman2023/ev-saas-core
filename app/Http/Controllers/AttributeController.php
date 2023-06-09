<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\AttributeRelationship;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        CoreComponentRepository::instantiateShopRepository();
        $attributes = Attribute::orderBy('created_at', 'desc')->get();

        return view('backend.attribute.index', compact('attributes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slug_index(Request $request, $slug)
    {
        $content_type = Product::class;
        switch ($slug) {
            case 'sellers':
                $content_type = 'App\Models\Seller';
                break;
            case 'product':
                $content_type = Product::class;
                break;
            case 'events':
                $content_type = 'App\Models\Event';
                break;
        }
        $attribute_groups = AttributeGroup::where('content_type', $content_type)->orderBy('created_at', 'desc')->get();
        $attributes = Attribute::where('content_type', $content_type)->orderBy('created_at', 'desc')->get();

        return view('backend.attribute.index', compact(['attributes', 'attribute_groups', 'content_type', 'slug']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new Attribute
        $attribute = new Attribute;
        $custom_properties = [];

        $attribute->name = $request->name;
        $attribute->type = $request->type;

        //Attribute Group
        if ($request->group != null) {
            if (strpos($request->group, 'existing_group_') !== false) {
                //If group exist
                $attribute->group = substr($request->group, 15);
            } else {
                //If group not exist, create new one
                $attribute_group = new AttributeGroup;
                $attribute_group->name = $request->group;
                $attribute_group->content_type = $request->content_type;
                $attribute_group->save();

                $attribute->group = $attribute_group->id;
            }
        }

        if ($request->filterable) {
            $attribute->filterable = 1;
        }
        if ($request->is_admin) {
            $attribute->is_admin = 1;
        }
        if ($request->is_schema) {
            $attribute->is_schema = 1;
            $attribute->schema_key = $request->schema_key;
            $attribute->schema_value = $request->schema_value;
        }

        if ($request->type === 'number') {
            $custom_properties['min_value'] = '';
            $custom_properties['max_value'] = '';
            $custom_properties['unit'] = '';

            $attribute->custom_properties = $custom_properties;
        } elseif ($attribute->type === 'dropdown' || $attribute->type === 'image') {
            $custom_properties['multiple'] = false;
            $attribute->custom_properties = $custom_properties;
        } elseif ($attribute->type === 'date') {
            $custom_properties['with_time'] = false;
            $custom_properties['range'] = false;
            $custom_properties['historic'] = false;
            $attribute->custom_properties = $custom_properties;
        }

        $attribute->content_type = $request->content_type;
        $attribute->save();

        // Create new Attribute Translation
        $attribute_translation = AttributeTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        flash(translate('Attribute has been inserted successfully'))->success();

        return redirect()->route('admin.attributes.slug_index', ['slug' => $request->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $attribute = Attribute::findOrFail($id);
        $custom_properties = $attribute->custom_properties;

        return view('backend.attribute.edit', compact('attribute', 'custom_properties', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        if ($request->lang == config('app.locale')) {
            $attribute->name = $request->name;
        }

        $attribute->filterable = $request->filterable == 'on' ? true : false;
        $attribute->is_admin = $request->is_admin == 'on' ? true : false;

        if ($request->is_schema == 'on') {
            $attribute->is_schema = 1;
            $attribute->schema_key = $request->schema_key;
            $attribute->schema_value = $request->schema_value;
        } else {
            $attribute->is_schema = 0;
            $attribute->schema_key = null;
            $attribute->schema_value = null;
        }

        if ($attribute->type === 'number') {
            $custom_properties = [];
            $custom_properties['min_value'] = $request->min_value;
            $custom_properties['max_value'] = $request->max_value;
            $custom_properties['unit'] = $request->unit ?? '';

            $attribute->custom_properties = $custom_properties;
        } elseif ($attribute->type === 'dropdown' || $attribute->type === 'image') {
            $custom_properties['multiple'] = ! empty($request->multiple);
            $attribute->custom_properties = $custom_properties;
        } elseif ($attribute->type === 'date') {
            $custom_properties['with_time'] = ! empty($request->with_time);
            $custom_properties['range'] = ! empty($request->range);
            $custom_properties['historic'] = ! empty($request->historic);
            $attribute->custom_properties = $custom_properties;
        }

        $attribute->save();

        $attribute_translation = AttributeTranslation::firstOrNew(['lang' => $request->lang, 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        flash(translate('Attribute has been updated successfully'))->success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        $slug = 'product';
        switch ($attribute->content_type) {
            case 'App\Models\Seller':
                $slug = 'sellers';
                break;
        }

        $attribute->delete();

        flash(translate('Attribute has been deleted successfully'))->success();

        return redirect()->route('admin.attributes.slug_index', ['slug' => $slug]);
    }

    /* Custom Functions */
    public function createAttributeValue($attribute, $value)
    {
        $attribute_value = new AttributeValue;
        $attribute_value->attribute()->associate($attribute);
        $attribute_value->values = $value;
        $attribute_value->save();
    }

    public function attribute_history($id)
    {
        $shop_audits = Audit::whereHasMorph('auditable', AttributeRelationship::class, function ($query) use ($id) {
            $query->where('subject_id', $id);
        })->orderBy('created_at', 'desc')->paginate(10);
        if ($shop_audits->count() > 0) {
            return view('backend.sellers.attribute_histories.index', compact('shop_audits'));
        }
        flash(translate('No company history available'))->warning();

        return back();
    }
}
