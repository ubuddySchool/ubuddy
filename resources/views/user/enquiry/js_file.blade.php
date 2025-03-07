<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    

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

   
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
</script>

