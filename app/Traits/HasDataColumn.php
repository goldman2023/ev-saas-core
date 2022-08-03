<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use App\Support\Eloquent\Casts\JsonData;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Closure;

trait HasDataColumn
{
    // This function can be overriden with corresponding json column name depending on model's table structure
    public function getDataColumnName()
    {
        return 'data';
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeHasDataColumn(): void
    {
        $this->casts = array_unique(
            array_merge($this->casts, [
                $this->getDataColumnName() => JsonData::class
            ])
        );
    }

    /*
     * Get any value from data column using a desired key (accepts dot notaion)
     */
    public function getData($key = null) {
        if(empty($key))
            return $this->{$this->getDataColumnName()};
            
        return Arr::get(empty($this->{$this->getDataColumnName()}) ? [] : $this->{$this->getDataColumnName()}, $key, null);
    }

    /*
     * Set any value from data column using a desired key (accepts dot notaion)
     */
    public function setData($key, $value = null, $default = null) {
        $data =  empty($this->{$this->getDataColumnName()}) ? [] : $this->{$this->getDataColumnName()};
        Arr::set($data, $key, empty($value) ? $default : $value);
        $this->{$this->getDataColumnName()} = $data;
    }

    /*
     * Merges new data with the old one (values for keys from new will override the old)
     */
    public function mergeData($new_data = []) {
        $old_data = empty($this->{$this->getDataColumnName()}) ? [] : $this->{$this->getDataColumnName()};
        $this->{$this->getDataColumnName()} = array_merge($old_data, $new_data);
    }

    public function keyExistsInData($key) {
        return Arr::has($this->{$this->getDataColumnName()}, $key);
    }
}
