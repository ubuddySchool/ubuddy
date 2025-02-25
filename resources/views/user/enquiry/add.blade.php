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
                        <div class="col">
                            <h3 class="page-title">New Enquiry Form</h3>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('enquiry.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name">School Name</label>
                                <input type="text" name="school_name" id="school_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" name="pincode" id="pincode" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">city</label>
                                <input type="text" name="city" id="city" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">state</label>
                                <input type="text" name="state" id="state" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">country</label>
                                <input type="text" name="country" id="country" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="students_count">Number of Students</label>
                                <input type="number" name="students_count" id="students_count" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="poc">Add POC</label>
                                <button type="button" class="btn btn-outline-primary" id="add_poc">Add POC</button>
                                <div id="poc_details" style="display:none;">
                                    <input type="text" name="poc_name" id="poc_name" class="form-control mt-2" placeholder="POC Name">
                                    <input type="text" name="poc_designation" id="poc_designation" class="form-control mt-2" placeholder="POC Designation">
                                    <input type="text" name="poc_contact" id="poc_contact" class="form-control mt-2" placeholder="POC Contact Number">
                                </div>
                            </div>
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
    // Show/hide logic for other board, website, software, and POC
    document.getElementById('other_board').addEventListener('change', function () {
        document.getElementById('other_board_name').style.display = 'block';
    });
    document.getElementById('mp_board').addEventListener('change', function () {
        document.getElementById('other_board_name').style.display = 'none';
    });

    document.getElementById('website_yes').addEventListener('change', function () {
        document.getElementById('website_url').style.display = 'block';
    });
    document.getElementById('website_no').addEventListener('change', function () {
        document.getElementById('website_url').style.display = 'none';
    });

    document.getElementById('software_yes').addEventListener('change', function () {
        document.getElementById('software_details').style.display = 'block';
    });
    document.getElementById('software_no').addEventListener('change', function () {
        document.getElementById('software_details').style.display = 'none';
    });

    document.getElementById('add_poc').addEventListener('click', function () {
        document.getElementById('poc_details').style.display = 'block';
    });
</script>

@endsection
