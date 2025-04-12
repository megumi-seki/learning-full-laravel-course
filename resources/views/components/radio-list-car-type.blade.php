<div class="row">
    @foreach ($carTypes as $carType)
    <div class="col">
        <label class="inline-radio">
          <input type="radio" name="car_type_id" value="{{ $carType->id }}"
           @checked($attributes->get("value") == $carType->id) />
          {{ $carType->name }}
        </label>
    </div>
        @if ($loop->iteration % 4 == 0 && !$loop->last)
</div>
<div class="row">
        @endif
    @endforeach
</div>