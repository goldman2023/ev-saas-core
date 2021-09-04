<?php

namespace App\Rules;

use Spatie\ValidationRules\Rules\ModelsExist;

class EVModelsExist extends ModelsExist
{
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;
        $value = is_array($value) ? array_filter($value) : (is_string($value) ? array_filter(explode(',', $value)) : []);

        $this->modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn($this->modelAttribute, $this->modelIds)->count();

        return count($this->modelIds) === $modelCount;
    }
}
