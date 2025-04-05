<h1>Hello From Laravel Course</h1>

{{ date("Y") }}
<p>{{ strtoupper($name . " " . $surname) }}</p>
<p>{!! $job !!}</p>
<p>{{ Illuminate\Support\Str::after("Hello World", "Hello ") }}</p>
<p>{{ Illuminate\Foundation\Application::VERSION }}</p>
<p>{{ PHP_VERSION }}</p>