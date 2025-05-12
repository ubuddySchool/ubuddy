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




@if(isset($enquiry->id))

<script>
    function toggleFollowUpDate(enquiryId) {
        // const dateInput = document.getElementById("follow_up_date_" + enquiryId);
        const dateInput = document.getElementById("follow_up_dates");
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


 {{-- JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const naCheckbox = document.getElementById('poc_ids_na');
        const pocCheckboxes = document.querySelectorAll('.poc-checkbox');

        naCheckbox.addEventListener('change', function () {
            pocCheckboxes.forEach(cb => {
                cb.disabled = naCheckbox.checked;
                if (naCheckbox.checked) {
                    cb.checked = false; // uncheck if disabled
                }
            });
        });
    });
</script>
