<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValueTranslation;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $lang      = $request->lang;
        $attribute = Attribute::findOrFail($request->attribute_id);
        return view('backend.attribute_value.create', compact(['attribute', 'lang']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);
        $lang = $request->lang;

        $attribute_value = new AttributeValue;
        $attribute_value->attribute_id = $request->attribute_id;
        $attribute_value->values = $request->name;
        $attribute_value->save();
        if($request->lang) {

        } else {
            /* TODO Falback value for incorect logic */
            $request->lang = "en";
        }

        $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => $request->lang, 'attribute_value_id' => $attribute_value->id]);
        $attribute_value_translation->name = $request->name;
        $attribute_value_translation->save();

        flash(translate('Attribute value has been inserted successfully'))->success();

        return redirect()->route('admin.attributes.edit', ['id'=>$attribute->id, 'lang'=>config('app.locale')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang      = $request->lang;
        $attribute_value = AttributeValue::findOrFail($id);
        return view('backend.attribute_value.edit', compact(['attribute_value', 'lang']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute_value = AttributeValue::findOrFail($id);
        if($request->lang == config('app.locale')){
            $attribute_value->values = $request->name;
        }
        $attribute_value->save();

        $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => $request->lang, 'attribute_value_id' => $attribute_value->id]);
        $attribute_value_translation->name = $request->name;
        $attribute_value_translation->save();

        flash(translate('Attribute value has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute_value = AttributeValue::findOrFail($id);
        $attribute = Attribute::findOrFail($attribute_value->attribute_id);

        $attribute_value->delete();

        flash(translate('Attribute value has been deleted successfully'))->success();

        return redirect()->route('admin.attributes.edit', ['id'=>$attribute->id, 'lang' => config('app.locale')]);
    }
}
