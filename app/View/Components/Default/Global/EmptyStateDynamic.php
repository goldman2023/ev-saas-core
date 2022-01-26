<?php

namespace App\View\Components\Default\Global;

use Illuminate\View\Component;

class EmptyStateDynamic extends Component
{

    public $title;
    public $description;
    public $cta;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Sorry, nothing matched your criteria', $description = "Can't find what you are looking for? Talk to a human!" , $cta = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->cta = $cta;

        /*  Set a default value for cta variable */
        if($this->cta == null)
        {
            $this->cta['url'] = route('search');
            $this->cta['text'] = translate('Back to Shop');
            $this->cta['class'] = 'btn btn-primary';
            $this->cta['target'] = '_self';
        }
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.global.empty-state-dynamic');
    }
}
