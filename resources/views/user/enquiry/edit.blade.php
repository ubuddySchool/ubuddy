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



                    <div class="modal-body">
                        <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- School Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_name{{ $enquiry->id }}">School Name</label>
                                        <input type="text" name="school_name" id="school_name{{ $enquiry->id }}" class="form-control" value="{{ old('school_name', $enquiry->school_name) }}" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address{{ $enquiry->id }}">Address</label>
                                        <input type="text" name="address" id="address{{ $enquiry->id }}" class="form-control" value="{{ old('address', $enquiry->address) }}" required>
                                    </div>
                                </div>

                                <!-- Pincode -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pincode{{ $enquiry->id }}">Pincode</label>
                                        <input type="text" name="pincode" id="pincode{{ $enquiry->id }}" value="{{ old('pincode', $enquiry->pincode) }}" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Town -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="town">Town</label>
                                        <input type="text" name="town" id="town{{ $enquiry->id }}" value="{{ old('town', $enquiry->town) }}" class="form-control select2">
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city{{ $enquiry->id }}">City</label>
                                        <input type="text" name="city" id="city{{ $enquiry->id }}" value="{{ old('city', $enquiry->city) }}" class="form-control" required readonly>
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state{{ $enquiry->id }}">State</label>
                                        <input type="text" name="state" id="state{{ $enquiry->id }}" value="{{ old('state', $enquiry->state) }}" class="form-control" required readonly>
                                    </div>
                                </div>

                                <!-- Current Software -->
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                        <input type="file" id="cameraInput_1" accept="image/*" name="images[]" capture="environment" style="display:none">
                                        <input type="file" id="galleryInput_1" name="images[]" accept="image/*" multiple style="display:none">

                                        <!-- Webcam (desktop) -->
                                        <div id="cameraContainer" class="mb-3" style="display: none;">
                                            <video id="video" width="320" height="240" autoplay></video><br>
                                            <button type="button" class="btn btn-sm btn-primary my-2" onclick="takePhoto()">📸 Capture Photo</button>
                                        </div>

                                        <!-- Previews -->
                                        <div id="gallery_1" class="mt-3 d-flex flex-wrap gap-2 justify-content-center"></div>
                                    </div>
                                </div>

                                <!-- Show existing images (from JSON) -->
                                @php
                                $images = json_decode($enquiry->images ?? '[]');
                                @endphp
                                <div class="col-md-12">

                                    @foreach($images as $index => $imagePath)
                                    <div class="position-relative" style="display:inline-block;">
                                        <img src="{{ asset($imagePath) }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteImage({{ $enquiry->id }}, {{ $index }})">×</button>
                                    </div>
                                    @endforeach

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
@endforeach
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($enquiries as $enquiry)
        (function() {
            const enquiryId = {{ $enquiry->id }};

            // Software
            const softwareYes = document.getElementById('software_yes' + enquiryId);
            const softwareNo = document.getElementById('software_no' + enquiryId);
            const softwareDetails = document.getElementById('software_details' + enquiryId);

            if (softwareYes && softwareNo && softwareDetails) {
                softwareYes.addEventListener('change', function () {
                    softwareDetails.style.display = 'block';
                });
                softwareNo.addEventListener('change', function () {
                    softwareDetails.style.display = 'none';
                });
            }

            // Website
            const websiteYes = document.getElementById('website_yes' + enquiryId);
            const websiteNo = document.getElementById('website_no' + enquiryId);
            const websiteUrl = document.getElementById('website_url' + enquiryId);

            if (websiteYes && websiteNo && websiteUrl) {
                websiteYes.addEventListener('change', function () {
                    websiteUrl.style.display = 'block';
                });
                websiteNo.addEventListener('change', function () {
                    websiteUrl.style.display = 'none';
                });
            }

            // Board
            const mpBoard = document.getElementById('mp_board' + enquiryId);
            const otherBoard = document.getElementById('other_board' + enquiryId);
            const otherBoardName = document.getElementById('other_board_name' + enquiryId);

            if (mpBoard && otherBoard && otherBoardName) {
                mpBoard.addEventListener('change', function () {
                    otherBoardName.style.display = 'none';
                });
                otherBoard.addEventListener('change', function () {
                    otherBoardName.style.display = 'block';
                });
            }
        })();
        @endforeach
    });
</script>


<script>
    function deleteImage(enquiryId, index) {
        if (confirm('Are you sure you want to delete this image?')) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const baseUrl = "{{ config('app.url') }}";
            const url = `${baseUrl}/enquiry/${enquiryId}/image/${index}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload(); // or remove image from DOM dynamically
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the image.');
                });
        }
    }
</script>




@include('user.enquiry.js_editfile')
@endsection