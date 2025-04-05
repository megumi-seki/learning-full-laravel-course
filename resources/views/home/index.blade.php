<h1>Hello From Laravel Course</h1>

{{-- @foreach ($hobbies as $h)
    @foreach ($hobbies as $h)
        {{ $loop->depth }}
        {{ $loop->parent->depth }}
    @endforeach
@endforeach --}}

{{-- <div @class([
    "my-css-class",
    "georgea" => $country === "ge"
    ])
    @style([
        "color: green",
        "background-color: cyan" => $country === "ge"
    ])>
    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo, quia itaque, pariatur eveniet blanditiis odio facilis nemo placeat recusandae sapiente quos excepturi obcaecati ex magnam autem libero necessitatibus inventore temporibus.

</div> --}}

{{-- @include("shared.button", ["color" => "yellow", "text" => "submit"])

@php
    $cars = [];
@endphp

@foreach ($cars as $car)
    @include("car.view", ["car" => $car])
@endforeach

@each("car.view", $cars, "car", "car.empty") --}}

{{-- @includeIf("shared.search_form", ["year" => 2019])
@includeWhen($searchKeyword, "shared.search_results", ["year" => 2019])
@includeUnless(!$searchKeyword, "shared.search_results", ["year" => 2019])
@includeFirst(['admin.button', 'button'], ['some' => 'data']) --}}

<?php 
$city = "tokyo";
?>
@php
$city = "tokyo"   
@endphp

<?php 
use Illuminate\Support\Str;
?>
@use('Illuminate\Support\Str;')