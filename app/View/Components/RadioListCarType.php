<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\CarType;
use Illuminate\Support\Collection;

class RadioListCarType extends Component
{
    public Collection $carTypes;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->carTypes = CarType::orderBy("name")->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-list-car-type');
    }
}
