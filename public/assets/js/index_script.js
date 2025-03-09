
function formatDate(input) {
    let value = input.value.replace(/\D/g, ''); 

    if (value.length > 8) {
        value = value.substring(0, 8); 
    }

    if (value.length >= 2) {
        let day = parseInt(value.substring(0, 2), 10);
        if (day < 1 || day > 31) {
            value = value.substring(0, 2); 
        }
    }

    if (value.length >= 4) {
        let month = parseInt(value.substring(2, 4), 10);
        if (month < 1 || month > 12) {
            value = value.substring(0, 4);
        }
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