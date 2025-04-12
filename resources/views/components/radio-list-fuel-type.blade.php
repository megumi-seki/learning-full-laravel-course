<div class="row">
    <div class="col">
        @foreach ($fuelTypes as $fuelType)
        <label class="inline-radio">
            <input type="radio" name="fuel_type_id" value="{{ $fuelType->id }}" 
            @checked($attributes->get("value") == $fuelType->id)/>
            {{ $fuelType->name }}
          </label>            
        @endforeach
    </div>
  </div>