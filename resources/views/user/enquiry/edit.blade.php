@extends('layouts.apphome')

@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                        <div class="col d-flex justify-content-between">
                                <h3 class="page-title">Edit Enquiry</h3>
                                <a href="{{ route('home') }}" class="btn btn-primary float-end">Back</a>
                            </div>
                        </div>
                    </div>
                    @foreach ($enquiries as $enquiry)

                    <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}">
                        @csrf
                        @method('PUT') <!-- This specifies that the form is for updating an existing resource -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <input type="text" name="school_name" id="school_name" class="form-control" value="{{ old('school_name', $enquiry->school_name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $enquiry->address) }}" required>
                                </div>
                            </div>

                         

                            <div class="col-md-3">
                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" name="pincode" id="pincode"  value="{{ old('pincode', $enquiry->pincode) }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $enquiry->city) }}" class="form-control" required readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" value="{{ old('state', $enquiry->state) }}" id="state" class="form-control" required readonly>
                </div>
            </div>

                            <div class="col-md-3">
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="students_count">Number of Students</label>
                                    <input type="number" name="students_count" class="form-control" value="{{ old('students_count', $enquiry->students_count) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
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
@endforeach

@include('user.enquiry.js_editfile')

@endsection
