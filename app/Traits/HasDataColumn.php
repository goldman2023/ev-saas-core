<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Closure;

trait HasDataColumn
{
    public function getDataColumnName()
    {
        return 'data';
    }

    /**
     * Get the License data
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => empty($value) ? [] : json_decode($value, true),
            set: function ($value) {
                if(!is_array($value) && !is_object($value)) {
                    $value = [];
                } else {
                    $value = json_encode($value);
                }
            }
        );
    }

    /*
     * Get any value from data column using a desired key (accepts dot notaion)
     */
    public function getData($key) {
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

    public function mergeData($new_data = []) {
        $old_data = empty($this->{$this->getDataColumnName()}) ? [] : $this->{$this->getDataColumnName()};
        $this->{$this->getDataColumnName()} = array_merge($old_data, $new_data);
    }
}
