@extends('layouts.apphome')

@section('content')
<div class="container mt-5">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col d-flex justify-content-between">
                                <h3 class="page-title">New Enquiry Form</h3>
                                <a href="{{ route('home') }}" class="btn btn-primary float-end">Back</a>
                            </div>


                        </div>
                    </div>


                    <form method="POST" action="{{ route('enquiry.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <input type="text" name="school_name" id="school_name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="board">Board</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="board" id="mp_board" value="MP Board">
                                            <label class="form-check-label" for="mp_board">MP Board</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="board" id="other_board" value="Other">
                                            <label class="form-check-label" for="other_board">Other</label>
                                        </div>
                                    </div>
                                    <input type="text" name="other_board_name" id="other_board_name" class="form-control mt-2" placeholder="Enter Board Name (if Other)" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="town">Town</label>
                                    <select name="town" id="town" class="form-control select2" required></select>
                                  
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" name="state" id="state" class="form-control" required>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">country</label>
                                <input type="text" name="country" id="country" class="form-control" required>
                            </div>
                        </div> -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="website" id="website_yes" value="yes">
                                            <label class="form-check-label" for="website_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="website" id="website_no" value="no">
                                            <label class="form-check-label" for="website_no">No</label>
                                        </div>
                                    </div>
                                    <input type="text" name="website_url" id="website_url" class="form-control mt-2" placeholder="Enter Website URL" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="students_count">Number of Students</label>
                                    <input type="number" name="students_count" id="students_count" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_software">Current Software</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="current_software" id="software_yes" value="1">
                                            <label class="form-check-label" for="software_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="current_software" id="software_no" value="0">
                                            <label class="form-check-label" for="software_no">No</label>
                                        </div>
                                    </div>
                                    <input type="text" name="software_details" id="software_details" class="form-control mt-2" placeholder="Enter Software Details" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                </div>
                            </div>

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="poc">Add POC</label>
                                    <button type="button" class="btn btn-outline-primary float-end btn-sm" id="add_poc">Add POC</button>
                                    <div id="poc_details_container">
                                        <div class="poc-item">
                                            <input type="text" name="poc_name[]" class="form-control mt-2" placeholder="POC Name" required>
                                            <input type="text" name="poc_designation[]" class="form-control mt-2" placeholder="POC Designation" required>
                                            <input type="text" name="poc_contact[]" class="form-control mt-2" placeholder="POC Contact Number" required>
                                            <button type="button" class="btn btn-danger remove_poc mt-2 btn-sm">Remove</button>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="poc_details" id="poc_details">
                                </div>
                            </div> -->
                            <div class="col-md-4">
                            <select class="form-select p-0 font-14" id="locationDropdownmap" aria-label="Location Dropdown">
                            </select>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
        let mapInstance;
        let mapInitialized = false;

        window.onload = function() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
              const userLat = position.coords.latitude;
              const userLon = position.coords.longitude;

              fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLon}`)
                .then(response => response.json())
                .then(data => {
                  const userAddress = data.display_name;
                  const locationDropdown = document.getElementById('locationDropdownmap');
                  const userOption = document.createElement('option');
                  userOption.textContent = ` ${userAddress}`;
                  userOption.value = 'current';
                  userOption.selected = true;
                  locationDropdown.insertBefore(userOption, locationDropdown.firstChild);
                })
                .catch(error => console.log('Reverse geocoding error:', error));

            }, () => {
              document.getElementById('distanceMiles').innerText = 'Location not available';
            });
          } else {
            document.getElementById('distanceMiles').innerText = 'Geolocation not supported';
          }
        };

      
      </script>

@include('user.enquiry.js_file')


@endsection