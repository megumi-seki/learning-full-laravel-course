<x-app-layout>
    <main>
        <div class="container-small">
          <h1 class="car-details-page-title">Add new car</h1>
          <form
            action="{{ route("car.store") }}"
            method="POST"
            enctype="multipart/form-data"
            class="card add-new-car-form"
          >
            @csrf
            {{-- @dump($errors) --}}
            {{-- @dump($errors->get("maker_id"))
            @dump($errors->all())
            @dump($errors->has("maker_id")) --}}
            {{-- @error("maker_id")
              There is error
              @enderror --}}
            <div class="form-content">
              <div class="form-details">
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('maker_id') has-error @enderror">
                      <label>Maker</label>
                      <x-select-maker :value="old('maker_id')" />
                      <p class="error-message">{{ $errors->first("maker_id") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group @error("car_model_id") has-error @enderror">
                      <label>Model</label>
                      <x-select-car-model :value="old('car_model_id')" />
                      <p class="error-message">{{ $errors->first("car_model_id") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group @error("year") has-error @enderror">
                      <label>Year</label>
                      <x-select-year :value="old('year')" />
                      <p class="error-message">{{ $errors->first("year") }}</p>
                    </div>
                  </div>
                </div>
                <div class="form-group @error('car_type_id') has-error @enderror">
                  <label>Car Type</label>
                  <x-radio-list-car-type :value="old('car_type_id')" />
                  <p class="error-message">{{ $errors->first("car_type_id") }}</p>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('price') has-error @enderror">
                      <label>Price</label>
                      <input type="number" placeholder="Price" name="price" value="{{ old('price') }}"/>
                      <p class="error-message">{{ $errors->first("price") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group @error('vin') has-error @enderror">
                      <label>Vin Code</label>
                      <input placeholder="Vin Code" name="vin" value="{{ old(key: 'vin') }}"/>
                      <p class="error-message">{{ $errors->first("vin") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group @error('mileage') has-error @enderror">
                      <label>Mileage (ml)</label>
                      <input placeholder="Mileage" name="mileage" value="{{ old(key: 'mileage') }}" />
                      <p class="error-message">{{ $errors->first("mileage") }}</p>
                    </div>
                  </div>
                </div>
                <div class="form-group @error('fuel_type_id') has-error @enderror">
                  <label>Fuel Type</label>
                  <x-radio-list-fuel-type :value="old('fuel_type_id')" />
                  <p class="error-message">{{ $errors->first("fuel_type_id") }}</p>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('state_id') has-error @enderror">
                      <label>State/Region</label>
                      <x-select-state :value="old('state_id')"/>
                      <p class="error-message">{{ $errors->first("state_id") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group  @error('city_id') has-error @enderror">
                      <label>City</label>
                      <x-select-city :value="old('city_id')" />
                      <p class="error-message">{{ $errors->first("city_id") }}</p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group  @error('address') has-error @enderror">
                      <label>Address</label>
                      <input placeholder="Address" name="address" value="{{ old('address' )}}"/>
                      <p class="error-message">{{ $errors->first("address") }}</p>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group  @error('phone') has-error @enderror">
                      <label>Phone</label>
                      <input placeholder="Phone" name="phone" value="{{ old('phone' )}}" />
                      <p class="error-message">{{ $errors->first("phone") }}</p>
                    </div>
                  </div>
                </div>
                  <x-checkbox-car-features />
                <div class="form-group @error('description') has-error @enderror">
                  <label>Detailed Description</label>
                  <textarea rows="10" name="description">{{ old('description' )}}</textarea>
                  <p class="error-message">{{ $errors->first("description") }}</p>
                </div>
                <div class="form-group  @error('published_at') has-error @enderror">
                  <label>Published Date</label>
                  <input type="date" name="published_at" value="{{ old('published_at' )}}">
                  <p class="error-message">{{ $errors->first("published_at") }}</p>
                </div>
              </div>
              <div class="form-images">
                @foreach ($errors->get("images.*") as $imageErrors)
                  @foreach ($imageErrors as $err)
                    <div class="text-error mb-small">{{ $err }}</div>                    
                  @endforeach
                @endforeach
                <div class="form-image-upload">
                  <div class="upload-placeholder">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      style="width: 48px"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                      />
                    </svg>
                  </div>
                  <input id="carFormImageUpload" type="file" name="images[]" multiple />
                  </div>
                  <div id="imagePreviews" class="car-form-images"></div>
                </div>
            </div>
            <div class="p-medium" style="width: 100%">
              <div class="flex justify-end gap-1">
                <button type="button" class="btn btn-default">Reset</button>
                <button class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
    </main>
</x-app-layout>
