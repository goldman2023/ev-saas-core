<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductActivity extends Component
{
    public $activity;
    public $product;
    public function mount($product)
    {
        $this->activity = \Spatie\Activitylog\Models\Activity::whereHas('subject')
            ->where('subject_id', $product->id)
            ->orderBy(
                'created_at',
                'desc'
            )->take(5)->get();
        $this->product = $product;
    }

    public function render()
    {
        $this->activity = \Spatie\Activitylog\Models\Activity::where('subject_id', $this->product->id)->orderBy(
            'created_at',
            'desc'
        )->take(5)->get();
        return view('livewire.product-activity');
    }
}
