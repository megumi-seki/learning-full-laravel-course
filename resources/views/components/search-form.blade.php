        <!-- Find a car form -->
        <section class="find-a-car">
            <div class="container">
              <form
                action="{{ $action }}"
                method="{{ $method }}"
                class="find-a-car-form card flex p-medium"
              >
                <div class="find-a-car-inputs">
                  <div>
                    <select id="makerSelect" name="maker_id">
                      <option value="">Maker</option>
                      <option value="4">Chevrolet</option>
                      <option value="2">Ford</option>
                      <option value="3">Honda</option>
                      <option value="6">Lexus</option>
                      <option value="5">Nissan</option>
                      <option value="1">Toyota</option>
                    </select>
                  </div>
                  <div>
                    <select id="modelSelect" name="model_id">
                      <option value="" style="display: block">Model</option>
                      <option value="50" data-parent="5" style="display: none">
                        370Z
                      </option>
                      <option value="6" data-parent="1" style="display: none">
                        4Runner
                      </option>
                      <option value="22" data-parent="3" style="display: none">
                        Accord
                      </option>
                      <option value="41" data-parent="5" style="display: none">
                        Altima
                      </option>
                      <option value="23" data-parent="3" style="display: none">
                        CR-V
                      </option>
                      <option value="37" data-parent="4" style="display: none">
                        Camaro
                      </option>
                      <option value="1" data-parent="1" style="display: none">
                        Camry
                      </option>
                      <option value="21" data-parent="3" style="display: none">
                        Civic
                      </option>
                      <option value="36" data-parent="4" style="display: none">
                        Colorado
                      </option>
                      <option value="2" data-parent="1" style="display: none">
                        Corolla
                      </option>
                    </select>
                  </div>
                  <div>
                    <select id="stateSelect" name="state_id">
                      <option value="">State/Region</option>
                      <option value="4">California</option>
                      <option value="2">Kansas</option>
                      <option value="1">Ohio</option>
                      <option value="5">Oregon</option>
                    </select>
                  </div>
                  <div>
                    <select id="citySelect" name="city_id">
                      <option value="" style="display: block">City</option>
                      <option value="3" data-parent="1" style="display: none">
                        Carmelstad
                      </option>
                      <option value="8" data-parent="2" style="display: none">
                        Cormierville
                      </option>
                      <option value="14" data-parent="3" style="display: none">
                        Dareville
                      </option>
                      <option value="13" data-parent="3" style="display: none">
                        Demarcotown
                      </option>
                      <option value="10" data-parent="2" style="display: none">
                        Doylebury
                      </option>
                      <option value="18" data-parent="4" style="display: none">
                        East Alfonso
                      </option>
                      <option value="9" data-parent="2" style="display: none">
                        East Ladarius
                      </option>
                      <option value="23" data-parent="5" style="display: none">
                        Kelvinmouth
                      </option>
                      <option value="24" data-parent="5" style="display: none">
                        Kemmerchester
                      </option>
                      <option value="25" data-parent="5" style="display: none">
                        Kunzeview
                      </option>
                    </select>
                  </div>
                  <div>
                    <select name="car_type_id">
                      <option value="">Type</option>
                      <option value="2">Hatchback</option>
                      <option value="6">Jeep</option>
                      <option value="5">Minivan</option>
                      <option value="4">Pickup Truck</option>
                      <option value="3">SUV</option>
                      <option value="1">Sedan</option>
                    </select>
                  </div>
                  <div>
                    <input type="number" placeholder="Year From" name="year_from" />
                  </div>
                  <div>
                    <input type="number" placeholder="Year To" name="year_to" />
                  </div>
                  <div>
                    <input
                      type="number"
                      placeholder="Price From"
                      name="price_from"
                    />
                  </div>
                  <div>
                    <input type="number" placeholder="Price To" name="price_to" />
                  </div>
                  <div>
                    <select name="fuel_type_id">
                      <option value="">Fuel Type</option>
                      <option value="2">Diesel</option>
                      <option value="3">Electric</option>
                      <option value="1">Gasoline</option>
                      <option value="4">Hybrid</option>
                    </select>
                  </div>
                </div>
                <div>
                  <button type="button" class="btn btn-find-a-car-reset">
                    Reset
                  </button>
                  <button class="btn btn-primary btn-find-a-car-submit">
                    Search
                  </button>
                </div>
              </form>
            </div>
          </section>
          <!--/ Find a car form -->