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

class MatchPassword implements Rule, ValidatorAwareRule, DataAwareRule
{
    protected $parameters;

    protected $validator;

    protected $data = [];

    public function __construct($parameters, $validator)
    {
        $this->parameters = $parameters;

        $this->setValidator($validator);
        $this->setData($validator->getData());
    }

    public function passes($attribute, $value): bool
    {
        $this->data = collect($this->data);
        $model_type = $this->parameters[0] ?? User::class;
        $model_identificator = $this->parameters[1];
        $data_key = $this->parameters[2] ?? null;

        // Check if user with email is not already registered.
        $model = app($model_type)::where($model_identificator, (! empty($data_key)) ? $this->data->pull($data_key) : $this->data->pull($model_identificator))->first();

        // If user already exists, check if provided password is the password for that user
        return $model instanceof User && ! empty($model->id ?? null) && Hash::check($value, $model->password);
    }

    public function validate($attribute, $value)
    {
        return $this->passes($attribute, $value);
    }

    public function message()
    {
        return translate('Password does not match a User with a given email.');
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function setData($data)
    {
        $this->data = collect($data);

        return $this;
    }
}
