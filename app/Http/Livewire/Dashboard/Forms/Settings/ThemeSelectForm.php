<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class ThemeSelectForm extends Component
{
    use DispatchSupport;

    public $themes;
    public $currentTheme;
    public $theme;
    public $domain;
    
    protected function rules()
    {
       return [
           'theme' => ['required', Rule::in(array_values(array_diff(scandir(base_path().'/themes'), array('..', '.'))))]
       ];
    }

    protected function messages()
    {
        return [
            'theme.required' => translate('Theme is required.'),
            'theme.in' => translate('Theme must be one of the available themes in dropdown.'),
        ];
    }
    
    /**
     * Mount a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->domain = tenant()->domains()->first();
        $this->currentTheme = $this->domain->theme;
        $this->theme = $this->domain->theme;
        $this->themes = collect(array_values(array_diff(scandir(base_path().'/themes'), array('..', '.'))))->keyBy(function ($item) {
            return $item;
        })->toArray();
    }

    public function saveTheme() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        try {
            $this->domain->theme = $this->theme;
            $this->domain->save();

            $this->currentTheme = $this->theme;

            $this->inform(translate('Application theme successfully changed!'), '', 'success');
        } catch(\Exception $e) {
            $this->inform(translate('Could not change app theme.'), $e->getMessage(), 'fail');
        }    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.dashboard.forms.settings.theme-select-form');
    }
}
