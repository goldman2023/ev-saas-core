<?php

namespace App\Rules;

use App\Models\ProductStock;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class IfIDExists implements Rule, ValidatorAwareRule, DataAwareRule
{

    protected $parameters;
    protected $validator;
    protected $data = [];

    public function __construct($parameters, $validator) {
        $this->parameters = $parameters;

        $this->setValidator($validator);
        $this->setData($validator->getData());
    }

    public function passes($attribute, $value): bool
    {
        $model_type = $this->parameters[0] ?? null;
        $model_identificator = $this->parameters[1];

        $value = $value instanceof Model ? $value->id : $value;

        if(!empty($model_type)) {
            // Check if user with email is not already registered.
            $model = app($model_type)::where($model_identificator, $value)->first();

            return !empty($model->id ?? null);
        }

        return false;
    }

    public function validate($attribute, $value) {
        return $this->passes($attribute, $value);
    }

    public function message()
    {
        return translate('Item under ID doesn\'t exist');
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
