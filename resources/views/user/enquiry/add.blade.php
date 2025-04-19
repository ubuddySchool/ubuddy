@extends('layouts.apphome')

@section('content')
<div class="container mt-5">


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


                    <form method="POST" action="{{ route('enquiry.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="school_name">School Name<span class="text-danger">*</span></label>
                                    <input type="text" name="school_name" id="school_name" value="{{ old('school_name') }}" class="form-control">
                                    @error('school_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="board">Board<span class="text-danger">*</span></label>
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
                                    @error('board') <span class="text-danger">{{ $message }}</span> @enderror
                                    <input type="text" name="other_board_name" id="other_board_name" class="form-control mt-2" placeholder="Enter Board Name (if Other)" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address<span class="text-danger">*</span></label>
                                    <input type="text" name="address" value="{{ old('address') }}" id="address" class="form-control">
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}" class="form-control">
                                    @error('pincode') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="town">Town<span class="text-danger">*</span></label>
                                    <select name="town" id="town" value="{{ old('town') }}" class="form-control select2"></select>
                                    @error('town') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City<span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control">
                                    @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State<span class="text-danger">*</span></label>
                                    <input type="text" name="state" id="state" value="{{ old('state') }}" class="form-control">
                                    @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website">Website<span class="text-danger">*</span></label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="website" id="website_yes" value="yes">
                                            <label class="form-check-label" for="website_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="website" id="website_no" value="no">
                                            <label class="form-check-label" for="website_no">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="website" id="website_yes" value="not_know">
                                            <label class="form-check-label" for="website_yes">Not know</label>
                                        </div>
                                    </div>
                                    @error('website') <span class="text-danger">{{ $message }}</span> @enderror
                                    <input type="text" name="website_url" id="website_url" class="form-control mt-2" placeholder="Enter Website URL" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="students_count">Number of Students<span class="text-danger">*</span></label>
                                    <input type="number" name="students_count" value="{{ old('students_count') }}" id="students_count" class="form-control">
                                    @error('students_count') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_software">Current Software<span class="text-danger">*</span></label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="current_software" id="software_yes" value="1">
                                            <label class="form-check-label" for="software_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="current_software" id="software_no" value="0">
                                            <label class="form-check-label" for="software_no">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="current_software" id="software_no" value="2">
                                            <label class="form-check-label" for="software_no">Not know</label>
                                        </div>
                                    </div>
                                    @error('current_software') <span class="text-danger">{{ $message }}</span> @enderror
                                    <input type="text" name="software_details" id="software_details" class="form-control mt-2" placeholder="Enter Software Details" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="remarks">Remarks<span class="text-danger">*</span></label>
                                    <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks') }}</textarea>
                                    @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label>Add Images (Max 3)</label>
                                <div class="border p-4 text-center bg-light rounded">

                                    <p id="uploadPrompt">Choose how to add images</p>

                                    <!-- Upload & Camera Buttons -->
                                    <div class="mb-3 d-flex justify-content-center gap-3">
                                        <button type="button" id="cameraBtn" class="btn btn-outline-success">📷 Use Camera</button>
                                        <button type="button" id="galleryBtn" class="btn btn-outline-primary">📁 Upload from Device</button>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="file" id="cameraInput" name="images[]" accept="image/*" capture="environment" style="display:none">
                                    <input type="file" id="galleryInput" name="images[]" accept="image/*" multiple style="display:none">

                                    <!-- Webcam (desktop) -->
                                    <div id="cameraContainer" class="mb-3" style="display: none;">
                                        <video id="video" width="320" height="240" autoplay></video><br>
                                        <button type="button" class="btn btn-sm btn-primary my-2" onclick="takePhoto()">📸 Capture Photo</button>
                                    </div>

                                    <!-- Previews -->
                                    <div id="gallery" class="mt-3 d-flex flex-wrap gap-2 justify-content-center"></div>
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




@include('user.enquiry.js_file')



@endsection