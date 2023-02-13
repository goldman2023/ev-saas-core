<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use WeTheme;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Symfony\Component\Process\Process;
use App\Traits\Livewire\DispatchSupport;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ThemeSelectForm extends Component
{
    use DispatchSupport;

    public $themes;

    public $currentTheme;

    public $theme;

    public $domain;

    public $currentThemeTailwindConfig;

    protected function rules()
    {
        return [
            'theme' => ['required', Rule::in(array_values(array_diff(scandir(base_path().'/themes'), ['..', '.'])))],
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
        $this->currentTheme = WeTheme::getThemeName();
        $this->theme = WeTheme::getThemeName();
        $this->themes = WeTheme::getAllThemes(for_selection: true);
        $this->all_themes = WeTheme::getAllThemes();

        $tailwind_config_json = $this->all_themes[$this->theme]['tailwind_config_json'];

        if(file_exists($tailwind_config_json)) {
            $this->currentThemeTailwindConfig = json_decode(file_get_contents($tailwind_config_json), true);
        }
    }

    public function saveTailwindConfig() {
        $tailwind_config_json = $this->all_themes[$this->theme]['tailwind_config_json'];

        try {
            $this->currentThemeTailwindConfig = file_put_contents($tailwind_config_json, json_encode($this->currentThemeTailwindConfig));
            // dd(var_dump(shell_exec('cd '.base_path() . '/themes/'.$this->currentTheme.' && npx mix --production --mix-config="themes/'.$this->theme.'/webpack.mix.js" 2>&1')));
            // , 'npx mix --production --mix-config="themes/'.$this->theme.'/webpack.mix.js"'
            // $process = new Process(['cd', base_path() . '\\themes\\'.$this->currentTheme]);
            // $process->run();

            // // executes after the command finishes
            // if (!$process->isSuccessful()) {
            //     throw new ProcessFailedException($process);
            // }

            // dd($process->getOutput());

            // TODO: Add running a sync or async process which basically runs the theme compilation function 
            $this->inform('Tailwind config successfully updated for theme'.': '.$this->theme, 'Please refresh the page to see changes...', 'success');
        } catch (\Exception $e) {
            dd($e);
            $this->inform(translate('Could not change app tailwind config...'), $e->getMessage(), 'fail');
        }
    }

    public function saveTheme()
    {
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
        } catch (\Exception $e) {
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
