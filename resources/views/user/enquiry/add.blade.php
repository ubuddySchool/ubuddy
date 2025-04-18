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
                            <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">country</label>
                                <input type="text" name="country" id="country" class="form-control" >
                            </div>
                        </div> -->

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
        <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display:none">
        <input type="file" id="galleryInput" accept="image/*" multiple style="display:none">

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
<!-- uploading image  -->
<script>
let stream;

// Start camera on desktop
function startCamera() {
    const cameraContainer = document.getElementById('cameraContainer');
    cameraContainer.style.display = 'block';

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(s => {
            stream = s;
            document.getElementById('video').srcObject = stream;
        })
        .catch(err => {
            alert('Camera access denied or not available');
            console.error(err);
        });
}

// Capture photo
function takePhoto() {
    const canvas = document.getElementById('canvas');
    const video = document.getElementById('video');
    const context = canvas.getContext('2d');
    const snapshotPreview = document.getElementById('snapshotPreview');

    canvas.style.display = 'block';
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert to image preview
    const imageDataUrl = canvas.toDataURL('image/jpeg');
    snapshotPreview.innerHTML = `
        <img src="${imageDataUrl}" class="img-thumbnail" width="100">
        <input type="hidden" name="captured_image" value="${imageDataUrl}">
    `;

    // Stop video stream
    stream.getTracks().forEach(track => track.stop());
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const MAX_FILES = 3;

    const gallery = document.getElementById('gallery');
    const uploadPrompt = document.getElementById('uploadPrompt');

    const cameraInput = document.getElementById('cameraInput');
    const galleryInput = document.getElementById('galleryInput');

    const cameraBtn = document.getElementById('cameraBtn');
    const galleryBtn = document.getElementById('galleryBtn');

    const cameraContainer = document.getElementById('cameraContainer');
    const video = document.getElementById('video');

    let stream;
    let filesArray = [];

    // Buttons
    cameraBtn.addEventListener('click', () => {
        if (isMobile()) {
            cameraInput.click(); // Use mobile's native camera
        } else {
            startWebcam(); // Use WebRTC on desktop
        }
    });

    galleryBtn.addEventListener('click', () => galleryInput.click());

    // Inputs
    cameraInput.addEventListener('change', () => handleFiles([...cameraInput.files]));
    galleryInput.addEventListener('change', () => handleFiles([...galleryInput.files]));

    function isMobile() {
        return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    }

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

    // Capture image from webcam
    window.takePhoto = function () {
        const canvas = document.createElement('canvas');
        canvas.width = 320;
        canvas.height = 240;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/jpeg');

        fetch(dataUrl)
            .then(res => res.blob())
            .then(blob => {
                if (filesArray.length >= MAX_FILES) {
                    alert(`Max ${MAX_FILES} images allowed.`);
                    return;
                }
                const file = new File([blob], `captured_${Date.now()}.jpg`, { type: 'image/jpeg' });
                filesArray.push(file);
                updateGallery();
            });

        // Stop camera
        stream.getTracks().forEach(track => track.stop());
        cameraContainer.style.display = 'none';
    }

    function handleFiles(newFiles) {
        if (filesArray.length + newFiles.length > MAX_FILES) {
            alert(`You can only upload a maximum of ${MAX_FILES} images.`);
            return;
        }

        newFiles.forEach(file => {
            if (filesArray.length < MAX_FILES) {
                filesArray.push(file);
            }
        });

        updateGallery();
    }

    function updateGallery() {
        gallery.innerHTML = '';
        uploadPrompt.style.display = filesArray.length ? 'none' : 'block';

        const dataTransfer = new DataTransfer();

        filesArray.forEach((file, index) => {
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
                    updateGallery();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                gallery.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
            dataTransfer.items.add(file);
        });

        galleryInput.files = dataTransfer.files;
        cameraInput.files = dataTransfer.files;
    }
});
</script>


@include('user.enquiry.js_file')



@endsection