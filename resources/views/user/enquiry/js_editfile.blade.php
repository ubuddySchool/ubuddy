
<script>
   

    document.addEventListener('DOMContentLoaded', function () {
    // Show/hide website URL input based on radio button selection
    document.querySelectorAll('input[name="website"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const websiteUrlInput = document.querySelector('input[name="website_url"]');
            if (this.value === 'yes') {
                websiteUrlInput.style.display = 'block';
            } else {
                websiteUrlInput.style.display = 'none';
            }
        });
    });

    // Show/hide software details input based on radio button selection
    document.querySelectorAll('input[name="current_software"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const softwareDetailsInput = document.querySelector('input[name="software_details"]');
            if (this.value === 'yes') {
                softwareDetailsInput.style.display = 'block';
            } else {
                softwareDetailsInput.style.display = 'none';
            }
        });
    });

    // Show POC details when Add POC button is clicked
    document.getElementById('add_poc').addEventListener('click', function () {
        document.getElementById('poc_details').style.display = 'block';
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Get all board radio buttons
    const boardRadios = document.querySelectorAll('input[name="board"]');
    const otherBoardInput = document.querySelector('input[name="other_board_name"]');

    // Function to toggle input field visibility
    function toggleOtherBoardInput() {
        if (document.querySelector('input[name="board"]:checked').value === 'Other') {
            otherBoardInput.style.display = 'block';
        } else {
            otherBoardInput.style.display = 'none';
            otherBoardInput.value = ''; // Clear the input if not needed
        }
    }

    // Attach event listeners to all radio buttons
    boardRadios.forEach(radio => {
        radio.addEventListener('change', toggleOtherBoardInput);
    });

    // Call function initially to set correct visibility on page load
    toggleOtherBoardInput();
});

</script>