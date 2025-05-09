<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use App\Models\CarModel;
use Illuminate\Support\Facades\Cache;

class SelectCarModel extends Component
{
    public Collection $models;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->models = Cache::rememberForever("caModels", function() {
            return CarModel::orderBy("name")->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-car-model');
    }
}
