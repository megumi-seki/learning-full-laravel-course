<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use App\Models\Maker;
use Illuminate\Support\Facades\Cache;

class SelectMaker extends Component
{
    public ?Collection $makers;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Put info in cache in default store
        // Cache::set("makers", "test", 50);
        // Cache::put("makers", "test", 5);
        // Cache::add("count", 0, now()->addMinutes(2));
        // Cache::increment("count", 2);

        // Put info in cache in file store
        // Cache::store("file")->set("makers", "test", 5);

        // $data = Cache::get("makers");
        // dump($data);

        // Check
        // Cache::has("makers"); // true|false

        // $this->makers = Cache::get("makers");
        // if ($this->makers === null) {
        //     $this->makers = Maker::orderBy("name")->get();
        //     Cache::set("makers", $this->makers);
        // }

        // Cache::forget("makers");
        // $makers = Cache::pull("makers"); // return and remove the data
        // Cache::put("makers", "", -1);
        // Cache::flush();  // delete everything

        // $maker = \cache("key");
        // \cache(["key" => ""], 10);
        // $maker = \cache()->remember("makers", 10, function() {
        //     return //
        // })

        $this->makers = Cache::rememberForever("makers",function() {
            return Maker::orderBy("name")->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-maker');
    }
}
