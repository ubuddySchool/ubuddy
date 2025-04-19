@extends('layouts.apphome')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <h3 class="page-title">Visit List</h3>
                        </div>


                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3 gap-md-2 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <label for="from_date" class="form-label mb-0  me-1">From:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="to_date" class="form-label mb-0 me-1">To:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                            value="{{ request('to_date') }}">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Today's / All Time Filter -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                <input type="checkbox"
                                    id="expiry_filter_switch"
                                    class="form-check-input"
                                    name="today_visit"
                                    value="today"
                                    onchange="this.form.submit()"
                                    {{ request('today_visit') == 'showall' ? 'checked' : '' }}>
                                <label for="expiry_filter_switch" class="form-label mb-0">Show all Visits</label>
                            </form>
                        </div>


                        <!-- Back Button Section -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm w-100 w-md-auto">Back</a>
                        </div>





                    </div>
                </div>
                <div class="page-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <div id="edit-full-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $enquiry->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel{{ $enquiry->id }}">Edit Enquiry</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}">
                    @csrf

                    <div class="row">
                        <!-- School Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name{{ $enquiry->id }}">School Name</label>
                                <input type="text" name="school_name" id="school_name{{ $enquiry->id }}" class="form-control" value="{{ old('school_name', $enquiry->school_name) }}" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address{{ $enquiry->id }}">Address</label>
                                <input type="text" name="address" id="address{{ $enquiry->id }}" class="form-control" value="{{ old('address', $enquiry->address) }}" required>
                            </div>
                        </div>

                        <!-- Pincode -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pincode{{ $enquiry->id }}">Pincode</label>
                                <input type="text" name="pincode" id="pincode{{ $enquiry->id }}" value="{{ old('pincode', $enquiry->pincode) }}" class="form-control" required>
                            </div>
                        </div>

                        <!-- Town -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="town">Town</label>
                                <input type="text" name="town" id="town{{ $enquiry->id }}" value="{{ old('town', $enquiry->town) }}" class="form-control select2">
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city{{ $enquiry->id }}">City</label>
                                <input type="text" name="city" id="city{{ $enquiry->id }}" value="{{ old('city', $enquiry->city) }}" class="form-control" required readonly>
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state{{ $enquiry->id }}">State</label>
                                <input type="text" name="state" id="state{{ $enquiry->id }}" value="{{ old('state', $enquiry->state) }}" class="form-control" required readonly>
                            </div>
                        </div>

                        <!-- Current Software -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_software{{ $enquiry->id }}">Current Software</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" id="software_yes{{ $enquiry->id }}" type="radio" name="current_software" value="1" {{ $enquiry->current_software == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="software_no{{ $enquiry->id }}" type="radio" name="current_software" value="0" {{ $enquiry->current_software == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                                <input type="text" name="software_details" id="software_details{{ $enquiry->id }}" class="form-control mt-2" placeholder="Enter Software Details" style="{{ $enquiry->current_software == '1' ? '' : 'display:none;' }}" value="{{ $enquiry->software_details }}">
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website{{ $enquiry->id }}">Website</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="website_yes{{ $enquiry->id }}" name="website" value="yes" {{ $enquiry->website == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="website_no{{ $enquiry->id }}" name="website" value="no" {{ $enquiry->website == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                                <input type="text" id="website_url{{ $enquiry->id }}" name="website_url" class="form-control mt-2" placeholder="Enter Website URL" style="{{ $enquiry->website == 'yes' ? '' : 'display:none;' }}" value="{{ $enquiry->website_url }}">
                            </div>
                        </div>

                        <!-- Board -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="board{{ $enquiry->id }}">Board</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="mp_board{{ $enquiry->id }}" name="board" value="MP Board" {{ $enquiry->board == 'MP Board' ? 'checked' : '' }}>
                                        <label class="form-check-label">MP Board</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="other_board{{ $enquiry->id }}" name="board" value="Other" {{ $enquiry->board == 'Other' ? 'checked' : '' }}>
                                        <label class="form-check-label">Other</label>
                                    </div>
                                </div>
                                <input type="text" name="other_board_name" id="other_board_name{{ $enquiry->id }}" class="form-control mt-2" placeholder="Enter Board Name (if Other)" style="{{ $enquiry->board == 'Other' ? '' : 'display:none;' }}" value="{{ $enquiry->other_board_name }}">
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="remarks{{ $enquiry->id }}">Remarks</label>
                                <textarea name="remarks" id="remarks{{ $enquiry->id }}" class="form-control">{{ old('remarks', $enquiry->remarks) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label>Add images (Max 3)</label>
                            <div class="border p-4 text-center bg-light rounded">

                                <p id="uploadPrompt_1">Choose how to add images</p>

                                <!-- Upload & Camera Buttons -->
                                <div class="mb-3 d-flex justify-content-center gap-3">
                                    <button type="button" id="cameraBtn_1" class="btn btn-outline-success">📷 Use Camera</button>
                                    <button type="button" id="galleryBtn_1" class="btn btn-outline-primary">📁 Upload from Device</button>
                                </div>

                                <!-- Hidden Inputs -->
                                <input type="file" id="cameraInput_1" accept="image/*" capture="environment" style="display:none">
                                <input type="file" id="galleryInput_1" accept="image/*" multiple style="display:none">

                                <!-- Webcam (desktop) -->
                                <div id="cameraContainer" class="mb-3" style="display: none;">
                                    <video id="video" width="320" height="240" autoplay></video><br>
                                    <button type="button" class="btn btn-sm btn-primary my-2" onclick="takePhoto()">📸 Capture Photo</button>
                                </div>

                                <!-- Previews -->
                                <div id="gallery_1" class="mt-3 d-flex flex-wrap gap-2 justify-content-center"></div>
                            </div>
                        </div>



                        <div class="col-md-12 text-end modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                        </div>
                        
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
</div>

@include('user.modal')

@endsection