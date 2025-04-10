<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use App\Models\City;

class SelectCity extends Component
{
    public Collection $cities;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cities = City::orderBy("name")->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-city');
    }
}
