@extends('layouts.apphome')

@section('content')
<div class="content container-fluid mt-1">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col align-items-center">
                                <a href="{{ route('home') }}" class="text-decoration-none text-dark me-2 backButton"> <i class="fas fa-arrow-left"></i></a>
                                <h3 class="page-title">Edit Enquiry</h3>
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
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="current_software" id="software_no" value="2" {{ $enquiry->current_software == '2' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="software_no">Not know</label>
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
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="website" id="website_not_know{{ $enquiry->id }}" value="not_know" {{ $enquiry->website == 'not_know' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="website">Not know</label>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_software">Interest in Software <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="interest_software" id="software_not_interested" value="0" {{ $enquiry->interest_software == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="software_not_interested">Not Interested</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="interest_software" id="software_interested" value="1" {{ $enquiry->interest_software == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="software_interested">Interested</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="interest_software" id="software_highly_interested" value="2" {{ $enquiry->interest_software == '2' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="software_highly_interested">Highly Interested</label>
                                            </div>
                                        </div>
                                        @error('interest_software') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="students_count">Number of Students<span class="text-danger">*</span></label>
                                    <input type="text" name="students_count" value="{{ old('students_count',$enquiry->students_count) }}" id="students_count" class="form-control"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                    @error('students_count') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                                <!-- Remarks -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="remarks{{ $enquiry->id }}">Remarks</label>
                                        <textarea id="message" name="remarks" id="remarks{{ $enquiry->id }}" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ old('remarks', $enquiry->remarks) }}</textarea>

                                        <!-- <textarea name="remarks" id="remarks{{ $enquiry->id }}" rows="3" class="form-control">{{ old('remarks', $enquiry->remarks) }}</textarea> -->
                                    </div>
                                </div>

                              

@php
    $images = json_decode($enquiry->images ?? '[]');
    $existingImageCount = count($images);
@endphp

<!-- Pass existing image count to JS -->
<script>
    const EXISTING_IMAGE_COUNT = {{ $existingImageCount }};
</script>

<!-- Existing images preview -->
<div class="col-md-12">
    @foreach($images as $index => $imagePath)
        <div class="position-relative d-inline-block m-1">
            <img src="{{ asset($imagePath) }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                    onclick="deleteImage({{ $enquiry->id }}, {{ $index }})">×</button>
        </div>
    @endforeach
</div>

<!-- Upload Section (will auto-hide if max reached) -->
<div id="imageUploader" class="col-md-12" {{ $existingImageCount >= 3  }}>
    <label>Add images (Max 3)</label>
    <div class="border p-4 text-center bg-light rounded">
        <p id="uploadPrompt_1">Choose how to add images</p>

        <div class="mb-3 d-flex justify-content-center gap-3">
            <button type="button" id="cameraBtn_1" class="btn btn-outline-success">📷 Use Camera</button>
            <button type="button" id="galleryBtn_1" class="btn btn-outline-primary">📁 Upload from Device</button>
        </div>

        <input type="file" id="cameraInput_1" accept="image/*" name="images[]" capture="environment" style="display:none">
        <input type="file" id="galleryInput_1" name="images[]" accept="image/*" multiple style="display:none">

        <div id="cameraContainer" class="mb-3" style="display: none;">
            <video id="video" width="320" height="240" autoplay></video><br>
            <button type="button" class="btn btn-sm btn-primary my-2" onclick="takePhoto()">📸 Capture Photo</button>
        </div>

        <div id="gallery_1" class="mt-3 d-flex flex-wrap gap-2 justify-content-center"></div>
    </div>
</div>




                                <div class="col-md-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
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


<!-- JS Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const MAX_FILES = 3;

        const gallery_1 = document.getElementById('gallery_1');
        const uploadPrompt_1 = document.getElementById('uploadPrompt_1');

        const cameraInput_1 = document.getElementById('cameraInput_1');
        const galleryInput_1 = document.getElementById('galleryInput_1');

        const cameraBtn_1 = document.getElementById('cameraBtn_1');
        const galleryBtn_1 = document.getElementById('galleryBtn_1');

        const cameraContainer = document.getElementById('cameraContainer');
        const video = document.getElementById('video');

        let stream;
        let filesArray = [];

        // Mobile check
        function isMobile() {
            return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        }

        // Start Webcam
        function startWebcam() {
            cameraContainer.style.display = 'block';
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => {
                    alert("Camera not accessible.");
                    console.error(err);
                });
        }

        // Capture photo from webcam
        window.takePhoto = function () {
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 240;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL('image/jpeg');

            fetch(dataUrl)
                .then(res => res.blob())
                .then(blob => {
                    const totalImages = EXISTING_IMAGE_COUNT + filesArray.length;
                    if (totalImages >= MAX_FILES) {
                        alert(`You can only upload a maximum of ${MAX_FILES} images.`);
                        return;
                    }
                    const file = new File([blob], `captured_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    filesArray.push(file);
                    updateGallery_1();
                });

            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            cameraContainer.style.display = 'none';
        }

        // Handle file input
        function handleFiles(newFiles) {
            const totalAvailableSlots = MAX_FILES - EXISTING_IMAGE_COUNT - filesArray.length;

            if (totalAvailableSlots <= 0) {
                alert(`You can only upload a maximum of ${MAX_FILES} images.`);
                return;
            }

            const filesToAdd = Array.from(newFiles).slice(0, totalAvailableSlots);

            if (filesToAdd.length < newFiles.length) {
                alert(`Only ${filesToAdd.length} more image(s) can be uploaded.`);
            }

            filesToAdd.forEach(file => filesArray.push(file));
            updateGallery_1();
        }

        function updateGallery_1() {
            gallery_1.innerHTML = '';
            uploadPrompt_1.style.display = filesArray.length ? 'none' : 'block';

            const dataTransfer = new DataTransfer();

            filesArray.forEach((file, index) => {
                dataTransfer.items.add(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = '×';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                    removeBtn.onclick = function () {
                        filesArray.splice(index, 1);
                        updateGallery_1();
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    gallery_1.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            galleryInput_1.files = dataTransfer.files;

            // Hide uploader if max reached
            // if (EXISTING_IMAGE_COUNT + filesArray.length >= MAX_FILES) {
            //     document.getElementById('imageUploader').style.display = 'none';
            // }
        }

        // Button actions
        cameraBtn_1.addEventListener('click', () => {
            if (isMobile()) {
                cameraInput_1.click();
            } else {
                startWebcam();
            }
        });

        galleryBtn_1.addEventListener('click', () => galleryInput_1.click());

        // Input listeners
        cameraInput_1.addEventListener('change', () => handleFiles([...cameraInput_1.files]));
        galleryInput_1.addEventListener('change', () => handleFiles([...galleryInput_1.files]));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($enquiries as $enquiry)
            (function() {
                const enquiryId = {
                    {
                        $enquiry - > id
                    }
                };

                // Software
                const softwareYes = document.getElementById('software_yes' + enquiryId);
                const softwareNo = document.getElementById('software_no' + enquiryId);
                const softwareDetails = document.getElementById('software_details' + enquiryId);

                if (softwareYes && softwareNo && softwareDetails) {
                    softwareYes.addEventListener('change', function() {
                        softwareDetails.style.display = 'block';
                    });
                    softwareNo.addEventListener('change', function() {
                        softwareDetails.style.display = 'none';
                    });
                }

                // Website
                const websiteYes = document.getElementById('website_yes' + enquiryId);
                const websiteNo = document.getElementById('website_no' + enquiryId);
                const websiteUrl = document.getElementById('website_url' + enquiryId);

                if (websiteYes && websiteNo && websiteUrl) {
                    websiteYes.addEventListener('change', function() {
                        websiteUrl.style.display = 'block';
                    });
                    websiteNo.addEventListener('change', function() {
                        websiteUrl.style.display = 'none';
                    });
                }

                // Board
                const mpBoard = document.getElementById('mp_board' + enquiryId);
                const otherBoard = document.getElementById('other_board' + enquiryId);
                const otherBoardName = document.getElementById('other_board_name' + enquiryId);

                if (mpBoard && otherBoard && otherBoardName) {
                    mpBoard.addEventListener('change', function() {
                        otherBoardName.style.display = 'none';
                    });
                    otherBoard.addEventListener('change', function() {
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