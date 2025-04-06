@extends("layouts.clean")

    @section("childContent")
        @include("layouts.partials.header")
        @yield("content")
        @hasSection("footerLinks")     
            <footer>
                 @yield("footerLinks")
            </footer>         
        @endif
    @endsection 


{{-- more directives
@hasSection("footerLinks")     
    <footer>
         @yield("footerLinks")
    </footer>         
@endif

@sectionMissing("navigation")
    <div>
      @include("default-navigation")
    </div>  
@endif

<input type="checkbox/radio" @checked(BOOLEAN_EXPRESSION)>
<input type="checked/radio" @disabled(BOOLEAN_EXPRESSION)>
<input type="text" @readonly(BOOLEAN_EXPRESSION)>
<input type="text" @required(BOOLEAN_EXPRESSION)>

<select name="year">
    @foreach ($years as $year)
        <option value="{{ $year }}" @selected($year == date("Y"))>
            {{ $year }}
        </option>
    @endforeach
</select> --}}
