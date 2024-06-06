function Titelinput() {
    var newValue = $(this).val();
    if (newValue.length > 30) {
        newValue = newValue.substring(0, 30);
        $('#titleHelp').html('<small class="form-text text-danger mb-5">* Maximum character limit is 18.</small>');
        $(this).removeClass('border-success').addClass('border-danger');
    } else {
        $('#titleHelp').text('');
        $(this).removeClass('border-danger').addClass('border-success');
    }
    $(this).val(newValue.replace(/[^a-zA-Z0-9\s]/g, ''));
}

function Descriptioninput() {
    var newValue = $(this).val();
    if (newValue.length > 220) {
        newValue = newValue.substring(0, 220);
        $('#descriptionHelp').html('<small class="form-text text-danger mb-5">* Maximum character limit is 220.</small>');
        $(this).removeClass('border-success').addClass('border-danger');
    } else {
        $('#descriptionHelp').text('');
        $(this).removeClass('border-danger').addClass('border-success');
    }
    $(this).val(newValue.replace(/[^a-zA-Z0-9\s.]/g, ''));
}

function Priceinput() {
    var newValue = $(this).val();

    // Remove non-numeric characters except for the first decimal point
    newValue = newValue.replace(/[^\d.]/g, '');

    // Allow only one decimal point in the input
    var parts = newValue.split('.');
    if (parts.length > 2) {
        newValue = parts[0] + '.' + parts.slice(1).join('');
    }

    // Truncate the value if it exceeds 8 characters
    if (newValue.length > 8) {
        newValue = newValue.slice(0, 8);
    }

    // Ensure only two decimal places
    if (newValue.includes('.')) {
        newValue = newValue.replace(/^(\d+\.\d{0,2})(\d*)/, '$1');
    }

    // Update the input value with the cleaned value
    $(this).val(newValue);
}

function Quantityinputvalidation() {
    var newValue = $(this).val();

    $('#quantityHelp').text('').removeClass('text-success text-danger');
    $(this).removeClass('border-success border-danger');

    $(this).val(newValue.replace(/[^0-9]/g, ''));

    // Remove non-numeric characters
    newValue = newValue.replace(/[^\d]/g, '');

    // Convert to number to check the value
    var numericValue = parseInt(newValue, 10);

    // Ensure the value is not greater than 10
    if (numericValue > 10) {
        $('#quantityHelp').text('* Maximum quantity is 10.').removeClass('text-success').addClass('text-danger');
        $(this).removeClass('border-success').addClass('border-danger');
        newValue = '10';
    }

    // Update the input value with the cleaned value
    $(this).val(newValue);
}

function updatePreview() {
    var title = $('#Titleinput').val();
    var description = $('#Descriptioninput').val();
    var price = $('#Priceinput').val();
    var quantity = $('#Quantityinput').val();
    var imageSrc = $('#imgPreview').attr('src');

    $("#Titleinput, #Descriptioninput, #Quantityinput, #Priceinput").on('input', function() {
        var newValue = $(this).val();
        $(this).toggleClass('border-success', newValue !== '');
    });

    // Update the preview elements with the new values
    $('.preview-title').text(title).addClass('border-success');
    var previewDescription = description.substring(0, 50); // Truncate the description to 50 characters
    if (description.length > 50) { // Add ellipsis if the description is truncated
        previewDescription += '...';
    }
    $('.preview-description').text(previewDescription);
    $('.preview-price').text(price + '$');
    $('.preview-quantity').text(quantity);

    if (title !== '' && description !== '' && price !== '' && quantity !== '' && imageSrc !== '') {
        $('.ready-to-sell').html('<span class="text-success"><i class="bi bi-check-circle-fill"></i></span>&nbsp;Ready to sell');
        $('#createButton').prop('disabled', false);
    } else {
        $('.ready-to-sell').text('');
        // disable button
        $('#createButton').prop('disabled', true);
    }
}
