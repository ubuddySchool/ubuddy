<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
 
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



    var baseUrl = "{{ env('APP_URL') }}";
    // var baseUrl = "http://localhost/ubuddy";
    console.log(baseUrl)
     $(document).ready(function () {
    $('#pincode').on('keyup', function () {
        let pincode = $(this).val();
        
        if (pincode.length === 6) { 
            $.ajax({
                url: baseUrl + "/get-location/" + pincode,
                type: "GET",
                success: function (data) {
                    console.log(data); 
                    
                    if (data.Status === "Success" && data.PostOffice.length > 0) {
                        let postOffice = data.PostOffice[0]; 
                        
                        $('#city').val(postOffice.District);
                        $('#state').val(postOffice.State); 
                    } else {
                        $('#city').val('');
                        $('#state').val('');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("API Error: " + error);
                    $('#city').val('');
                    $('#state').val('');
                }
            });
        }
    });
});

var baseUrl = "{{ env('APP_URL') }}";
$(document).ready(function () {
    $('#pincode').on('keyup', function () {
        let pincode = $(this).val();
        
        if (pincode.length === 6) {
            $.ajax({
                url: baseUrl + "/get-location/" + pincode,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    
                    if (data.Status === "Success" && data.PostOffice.length > 0) {
                        let postOffices = data.PostOffice;

                        // Clear existing options and use Select2
                        $('#town').empty();  // Empty current options

                        // Populate Select2 with new options
                        postOffices.forEach(function(postOffice) {
                            $('#town').append(new Option(postOffice.Name, postOffice.Name));  // Adding each town as an option
                        });

                       
                        $('#town').select2();
                        // let postOffice = data.PostOffice[0]; 
                        
                        $('#city').val(postOffice.District);
                        $('#state').val(postOffice.State); 
                        // Set city and state
                        // $('#city').val(postOffices[0].District);
                        // $('#state').val(postOffices[0].State);
                    } else {
                        $('#city').val('');
                        $('#state').val('');
                        $('#town').val('').trigger('change'); // Reset Select2
                    }
                },
                error: function (xhr, status, error) {
                    console.error("API Error: " + error);
                    $('#city').val('');
                    $('#state').val('');
                    $('#town').val('').trigger('change'); // Reset Select2
                }
            });
        }
    });
});

$('#town').select2({
    placeholder: 'Select a town',
    allowClear: true
})


   
</script>
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

        // Detect Mobile
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

        // Capture from Webcam
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
                    updateGallery_1();
                });

            // Stop webcam
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            cameraContainer.style.display = 'none';
        }

        // Handle Image Selection
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

            updateGallery_1();
        }

        // Update Image Preview + Sync Input Files
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

            // ✅ Only set files to one input (prevent duplication)
            galleryInput_1.files = dataTransfer.files;
        }

        // Trigger File Inputs
        cameraBtn_1.addEventListener('click', () => {
            if (isMobile()) {
                cameraInput_1.click(); // Native Camera on mobile
            } else {
                startWebcam(); // Desktop webcam
            }
        });

        galleryBtn_1.addEventListener('click', () => galleryInput_1.click());

        // Input Change Listeners
        cameraInput_1.addEventListener('change', () => handleFiles([...cameraInput_1.files]));
        galleryInput_1.addEventListener('change', () => handleFiles([...galleryInput_1.files]));
    });
</script>




<script>
    let stream;

    // Start camera on desktop
    function startCamera() {
        const cameraContainer = document.getElementById('cameraContainer');
        cameraContainer.style.display = 'block';

        navigator.mediaDevices.getUserMedia({
                video: true
            })
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
    document.addEventListener("DOMContentLoaded", function() {
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
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
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
        window.takePhoto = function() {
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
                    const file = new File([blob], `captured_${Date.now()}.jpg`, {
                        type: 'image/jpeg'
                    });
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
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = '×';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                    removeBtn.onclick = function() {
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

<!-- 
<script>
    let mapInstance;
    let mapInitialized = false;

    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLon}`)
                    .then(response => response.json())
                    .then(data => {
                        const userAddress = data.display_name;

                        // Store value in text input
                        const locationInput = document.getElementById('locationInput');
                        locationInput.value = userAddress;

                        // Optional: Add to dropdown
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
</script> -->


@if(isset($enquiry->id))

<script>
    function toggleFollowUpDate(enquiryId) {
        const dateInput = document.getElementById("follow_up_date_" + enquiryId);
        const checkbox = document.getElementById("not_fixed_" + enquiryId);
        dateInput.disabled = checkbox.checked;
    }

    document.getElementById('visitForm').addEventListener('submit', function (e) {
        const messages = [];
        let isValid = true;

        // Clear previous messages
        document.querySelectorAll('.validation-message').forEach(el => el.innerText = '');

        // Validate Visit Type
        if (!document.querySelector('input[name="contact_method"]:checked')) {
            isValid = false;
            document.querySelector('[data-field="contact_method"]').innerText = "Please select a Visit Type.";
        }

        // Validate Visit Time
        const hour = document.querySelector('select[name="hour_of_visit"]').value;
        const minute = document.querySelector('select[name="minute_of_visit"]').value;
        const ampm = document.querySelector('select[name="am_pm"]').value;
        if (!hour || !minute || !ampm) {
            isValid = false;
            document.querySelector('[data-field="visit_time"]').innerText = "Complete Visit Time is required.";
        }

        // Validate POC
        if (!document.querySelector('input[name="poc_ids[]"]:checked')) {
            isValid = false;
            document.querySelector('[data-field="poc_ids"]').innerText = "Please select at least one POC.";
        }

        // Validate Visit Status
        if (!document.querySelector('input[name="update_status"]:checked')) {
            isValid = false;
            document.querySelector('[data-field="update_status"]').innerText = "Please select a Visit Status.";
        }

        // Validate Visit Remarks
        const visitRemarks = document.querySelector('input[name="visit_remarks"]').value;
        if (!visitRemarks) {
            isValid = false;
            document.querySelector('[data-field="visit_remarks"]').innerText = "Visit Remarks is required.";
        }

        // Validate Follow-Up Date or Not Fixed
       
        const dateInput = document.getElementById("follow_up_date_{{ $enquiry->id }}");
    const notFixed = document.getElementById("not_fixed_{{ $enquiry->id }}");

    // Check if Not Fixed is unchecked and the date input is empty or disabled
    if (!notFixed.checked && (!dateInput.value || dateInput.disabled)) {
        isValid = false;
        document.querySelector('[data-field="follow_up_date"]').innerText = "Please enter a date or check 'Not Fixed'.";
    }

        if (!isValid) {
            e.preventDefault();
        }
    });

    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.display_name;
                        document.getElementById('locationInput').value = address;
                        document.getElementById('googleMapLink').href = `https://www.google.com/maps?q=${lat},${lon}`;
                        document.getElementById('googleMapLink').textContent = "View on Google Maps";
                        document.getElementById('googleMapLink').style.display = "inline";
                    })
                    .catch(error => console.error('Error getting location:', error));
            });
        }
    };
</script>
@endif
