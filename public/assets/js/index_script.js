
function formatDate(input) {
    let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters

    if (value.length > 8) {
        value = value.substring(0, 8); // Restrict input to 8 digits (DDMMYYYY)
    }

    let formatted = '';
    if (value.length > 4) {
        formatted = value.substring(0, 2) + '-' + value.substring(2, 4) + '-' + value.substring(4, 8);
    } else if (value.length > 2) {
        formatted = value.substring(0, 2) + '-' + value.substring(2);
    } else {
        formatted = value;
    }

    input.value = formatted;
}


    function showPocForm() {
        alert('Open POC form here to add a new contact.');
    }

    function showPocForm(enquiryId) {
        document.getElementById('poc-form-' + enquiryId).style.display = 'block';
    }

    function hidePocForm(enquiryId) {
        document.getElementById('poc-form-' + enquiryId).style.display = 'none';
    }

    function saveNewPoc(enquiryId) {
        let name = document.getElementById('new_poc_name_' + enquiryId).value;
        let contact = document.getElementById('new_poc_contact_' + enquiryId).value;

        if (name.trim() === '' || contact.trim() === '') {
            alert('Please fill in all fields.');
            return;
        }

        let newPocHtml = `
        <div class="form-check">
            <input class="form-check-input" type="radio" name="poc_${enquiryId}" value="${name}">
            <label class="form-check-label">${name} (${contact})</label>
        </div>
    `;

        document.getElementById('poc-form-' + enquiryId).insertAdjacentHTML('beforebegin', newPocHtml);
        hidePocForm(enquiryId);
    }