<h1>Hello From Laravel Course</h1>

<!-- this comment is visible -->
{{-- This comment is invisible --}}

{{-- every directive needs to be closed --}}
@if (false) This will be displayed @endif
@unless () 
@isset()
@empty()
@auth {{--check if user is authenticated--}}
@guest {{--check if user is guest--}}
@switch()
    @case()
        @break
    @case()
        @break
    @default
@endswitch

@for ($i =0; $i < 5; $i++)
    <p> {{ $i + 1 }} </p>
@endfor

@foreach ($cars as $car)
    <p>Model: {{ $car->model }}</p>
@endforeach

@forelse ($cars as $car)
    <p>Model: {{ $car->model }}</p>
@empty
    <p>There are no cars</p>
@endforelse

@while (false)
    
@endwhile

@foreach ([1, 2, 3, 4, 5] as $num)
    @if ($num == 2)
        @continue
    @endif
    <p>{{$num}}</p>
@endforeach

@foreach ([1, 2, 3, 4, 5] as $num)
    @continue($num ==2)
    <p>{{$num}}</p>
@endforeach

@foreach ([1, 2, 3, 4, 5] as $num)
    @if ($num == 4)
        @break
    @endif
    <p>{{$num}}</p>
@endforeach

@foreach ([1, 2, 3, 4, 5] as $num)
    @break($num == 4)
    <p>{{$num}}</p>
@endforeach