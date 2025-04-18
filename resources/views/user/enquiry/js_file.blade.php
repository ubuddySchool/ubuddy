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
     document.addEventListener("DOMContentLoaded", function() {
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

        // Buttons
        cameraBtn_1.addEventListener('click', () => {
            if (isMobile()) {
                cameraInput_1.click(); // Use mobile's native camera
            } else {
                startWebcam(); // Use WebRTC on desktop
            }
        });

        galleryBtn_1.addEventListener('click', () => galleryInput_1.click());

        // Inputs
        cameraInput_1.addEventListener('change', () => handleFiles([...cameraInput_1.files]));
        galleryInput_1.addEventListener('change', () => handleFiles([...galleryInput_1.files]));

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
                    updateGallery_1();
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

            updateGallery_1();
        }

        function updateGallery_1() {
            gallery_1.innerHTML = '';
            uploadPrompt_1.style.display = filesArray.length ? 'none' : 'block';

            const dataTransfer_1 = new DataTransfer();

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
                        updateGallery_1();
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    gallery_1.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
                dataTransfer_1.items.add(file);
            });

            // Set files to both inputs to support form submission
            galleryInput_1.files = dataTransfer_1.files;
            cameraInput_1.files = dataTransfer_1.files;
        }
    });
</script>
<!-- <script>
$(document).ready(function() {
    $('#add_poc').on('click', function() {
        const pocItemHtml = `
            <div class="poc-item">
                <input type="text" name="poc_name[]" class="form-control mt-2" placeholder="POC Name" required>
                <input type="text" name="poc_designation[]" class="form-control mt-2" placeholder="POC Designation" required>
                <input type="text" name="poc_contact[]" class="form-control mt-2" placeholder="POC Contact Number" required>
                <button type="button" class="btn btn-danger remove_poc mt-2 btn-sm">Remove</button>
            </div>
        `;
        $('#poc_details_container').append(pocItemHtml); // Append the new POC input fields
    });

    // Remove a POC entry when the remove button is clicked
    $(document).on('click', '.remove_poc', function() {
        $(this).closest('.poc-item').remove(); // Remove the POC item containing the clicked remove button
    });

    // Form submission handling (before submission)
    $('form').on('submit', function(e) {
        // Collect all POC details
        let pocDetails = [];
        $('.poc-item').each(function() {
            const pocName = $(this).find('input[name="poc_name[]"]').val();
            const pocDesignation = $(this).find('input[name="poc_designation[]"]').val();
            const pocContact = $(this).find('input[name="poc_contact[]"]').val();
            
            // Push the POC details to the array if all values are not empty
            if (pocName && pocDesignation && pocContact) {
                pocDetails.push({
                    poc_name: pocName,
                    poc_designation: pocDesignation,
                    poc_contact: pocContact
                });
            }
        });

        // Attach the POC details as JSON to the hidden input
        $('#poc_details').val(JSON.stringify(pocDetails));

        return true;
    });
});
</script> -->

