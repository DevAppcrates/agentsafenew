                        <?php $hours = \App\Hours::orderBy('hour','asc')->get(); ?>
                        {{-- {{ dd($days) }} --}}

                        @foreach($days as $day)
                        <br>
                        
                        <div class="row">
                          
                        <div class="col-sm-3">
                        <label ><strong style="float:left;font-size: 20px!important;">{{ $day->name }}:</strong></label>
                                                   
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-4">
                          <select class="selectpicker form-control" data-style="red" name="{{ strtolower($day->name) }}_status">
                              <option value="active">Active</option>
                              <option value="inactive">inactive</option>
                           </select>
                        </div>
                          <div class="col-sm-4">
                             <select class="selectpicker form-control" data-style="red" name="{{ strtolower($day->name) }}_start_time">
                                <option value=""> Set start time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}">{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                             <br>
                              <select class="selectpicker form-control" data-style="red" name="{{ strtolower($day->name) }}_start_time_am_pm">
                                <option value="am"> AM</option>
                                <option value="pm"> PM</option>
                             </select>
                          </div>

                          <div class="col-sm-4">
                             <select class="selectpicker form-control" data-style="red" name="{{ strtolower($day->name) }}_close_time">
                                <option value=""> Set Close time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}">{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                             <select class="selectpicker form-control" data-style="red" name="{{ strtolower($day->name) }}_close_time_am_pm">
                                <option value="am"> AM</option>
                                <option value="pm"> PM</option>
                             </select>
                          </div>
                        </div>
                        <br>
                        @endforeach