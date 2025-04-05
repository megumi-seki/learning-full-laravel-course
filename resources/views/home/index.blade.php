<h1>Hello From Laravel Course</h1>

<script>
    const hobbies = {{ Js::from($hobbies) }}
</script>

@verbatim
<div>
    Name: {{ name }}
    Age: {{ age }}
    Job: {{ job }}
    Hobbies: {{ hobbies }}
    @if
</div>
@endverbatim
