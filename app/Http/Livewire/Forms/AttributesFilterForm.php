<?php

namespace App\Http\Livewire\Forms;

use Log;
use Str;
use AttributesService;
use App\Models\User;
use Livewire\Component;
use App\Enums\WeMailingListsEnum;
use Illuminate\Support\Collection;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\ContactNotification;

class AttributesFilterForm extends Component
{
    use DispatchSupport;

    public $attributes;
    public $selected_attributes;
    public $count_active_filters;
    public $currentUrl;
    public $query_params;

    protected function rules()
    {
        return [
            'attributes.*' => '',
            'query_params.*' => '',
            'selected_attributes.*' => '',
            'selected_attributes.*.*' => '',
        ];
    }

    protected function messages()
    {
        return [

        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($attributes)
    {
        $this->currentUrl = url()->current();
        $this->query_params = request()->query();
        $this->attributes = $attributes;
        
        foreach($this->attributes as &$attribute) {
            $attribute->attribute_predefined_values; // TODO: This line is written so bad that it hurts , cuz fucking eager-load and load do not work due to issues here: https://app.asana.com/0/1202463780295485/1204008039607518
        }

        $selected_product_attributes = AttributesService::castFilterableProductAttributesFromQueryParams($this->attributes);
        
        $this->selected_attributes = $selected_product_attributes['selected_attributes'];
        $this->count_active_filters = $selected_product_attributes['count_active_filters'];

        // $this->selected_attributes['sranje_25'] = array_values(array_unique($this->selected_attributes['attribute_11']));
        // dd($this->selected_attributes);
    }

    public function render()
    {
        return view('livewire.forms.attributes-filter-form');
    }

    public function filter()
    {
        $query_params = http_build_query($this->selected_attributes);
        return redirect()->to($this->currentUrl.'?'.$query_params);
    }

    public function resetForm() {
        $this->selected_attributes = [];
    }
}
