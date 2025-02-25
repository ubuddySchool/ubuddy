@extends('layouts.apphome')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Edit Enquiry</h3>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}">
                        @csrf
                        @method('PUT') <!-- This specifies that the form is for updating an existing resource -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <input type="text" name="school_name" id="school_name" class="form-control" value="{{ old('school_name', $enquiry->school_name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="board">Board</label>
                                    <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="board" value="MP Board" {{ $enquiry->board == 'MP Board' ? 'checked' : '' }}>
                                        <label class="form-check-label">MP Board</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="board" value="Other" {{ $enquiry->board == 'Other' ? 'checked' : '' }}>
                                        <label class="form-check-label">Other</label>
                                    </div>
                                    </div>
                                    <input type="text" name="other_board_name" class="form-control mt-2" placeholder="Enter Board Name (if Other)" style="{{ $enquiry->board == 'Other' ? '' : 'display:none;' }}" value="{{ $enquiry->other_board_name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $enquiry->address) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $enquiry->pincode) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $enquiry->city) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" value="{{ old('country', $enquiry->country) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="website" value="yes" {{ $enquiry->website == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="website" value="no" {{ $enquiry->website == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    </div>
                                    <input type="text" name="website_url" class="form-control mt-2" placeholder="Enter Website URL" style="{{ $enquiry->website == 'yes' ? '' : 'display:none;' }}" value="{{ $enquiry->website_url }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="students_count">Number of Students</label>
                                    <input type="number" name="students_count" class="form-control" value="{{ old('students_count', $enquiry->students_count) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_software">Current Software</label>
                                        <div class="d-flex gap-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="current_software" value="yes" {{ $enquiry->current_software == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="current_software" value="no" {{ $enquiry->current_software == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label">No</label>
                                            </div>
                                        </div>
                                    <input type="text" name="software_details" class="form-control mt-2" placeholder="Enter Software Details" style="{{ $enquiry->current_software == 'yes' ? '' : 'display:none;' }}" value="{{ $enquiry->software_details }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control">{{ old('remarks', $enquiry->remarks) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="poc">Add POC</label>
                                    <button type="button" class="btn btn-outline-primary" id="add_poc">Add POC</button>
                                    <div id="poc_details" style="{{ $enquiry->poc_name ? '' : 'display:none;' }}">
                                        <input type="text" name="poc_name" class="form-control mt-2" placeholder="POC Name" value="{{ $enquiry->poc_name }}">
                                        <input type="text" name="poc_designation" class="form-control mt-2" placeholder="POC Designation" value="{{ $enquiry->poc_designation }}">
                                        <input type="text" name="poc_contact" class="form-control mt-2" placeholder="POC Contact Number" value="{{ $enquiry->poc_contact }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add similar JS logic to show/hide fields as in the create form
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
