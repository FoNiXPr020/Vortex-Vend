/**
 * Checks if the given email is a valid email format.
 *
 * @param {string} email - The email to be validated.
 * @return {boolean} Returns true if the email is valid, false otherwise.
 */
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Checks if a password meets the specified requirements.
 *
 * @param {string} value - The password to be checked.
 * @param {Array} requirements - An array of objects representing the requirements.
 * @param {RegExp} requirements[].regex - The regular expression to test against the password.
 * @param {string} requirements[].message - The error message to display if the requirement is not met.
 * @return {Object} An object containing the result of the requirements check.
 * @return {boolean} requirementsMet - Indicates if all requirements are met.
 * @return {string} requirementsText - The concatenated error messages for the failed requirements.
 */
function checkRequirements(value, requirements) {
    let requirementsMet = true;
    let requirementsText = '';

    requirements.forEach(requirement => {
        if (!requirement.regex.test(value)) {
            requirementsMet = false;
            requirementsText += requirement.message + '<br>';
        }
    });

    return {
        requirementsMet: requirementsMet,
        requirementsText: requirementsText
    }
}

function firstName() {
    var firstName = $(this).val();

    // Check if the name is empty
    if (!firstName.trim()) {
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }

    // Check if name meets requirements of only letters and between 2 and 15 characters
    const firstNameRequirements = [
        {
            regex: /^[a-zA-Z]+$/,
            message: ''
        },
        {
            regex: /^[a-zA-Z]{2,15}$/,
            message: ''
        }
    ];

    const requirements = checkRequirements(firstName, firstNameRequirements);

    // Update UI based on requirements met
    if (requirements['requirementsMet']) {
        $(this).removeClass('border-danger border-dark').addClass('border-success');
    } else {
        $(this).removeClass('border-success border-dark').addClass('border-danger');
    }

}

function lastName() {
    var lastName = $(this).val();

    // Check if the name is empty
    if (!lastName.trim()) {
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }

    // Check if name meets requirements of only letters and between 2 and 15 characters
    const firstNameRequirements = [
        {
            regex: /^[a-zA-Z]+$/,
            message: ''
        },
        {
            regex: /^[a-zA-Z]{2,15}$/,
            message: ''
        }
    ];

    const requirements = checkRequirements(lastName, firstNameRequirements);

    // Update UI based on requirements met
    if (requirements['requirementsMet']) {
        $(this).removeClass('border-danger border-dark').addClass('border-success');
    } else {
        $(this).removeClass('border-success border-dark').addClass('border-danger');
    }

}

function CheckUsername() {
    var username = $(this).val();

    // Check if the username is empty
    if (!username.trim()) {
        $('#usernameHelp').text('');
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if username is empty
    }

    // Check if username meets requirements
    const UserRequirements = [{
        regex: /.{6,12}/,
        message: '* Username must be between 6-12 characters.'
    },
    {
        regex: /[a-z]/,
        message: '* Username must contain a-z characters.'
    },
    {
        regex: /[A-Z]/,
        message: '* Username must contain A-Z characters.'
    },
    {
        regex: /\d/,
        message: '* Username must contain numbers.'
    },
    {
        regex: /^[a-zA-Z0-9]*$/,
        message: '* Username must not contain special characters.'
    }
    ];

    const requirements = checkRequirements(username, UserRequirements);

    // Update UI based on requirements met
    if (requirements['requirementsMet']) {
        $('#usernameHelp').removeClass('text-danger').addClass('text-success').text('');
        $(this).removeClass('border-danger border-dark').addClass('border-success');
        UsernameFields = true;
    } else {
        $('#usernameHelp').removeClass('text-success').addClass('text-danger').html(requirements['requirementsText']);
        $(this).removeClass('border-success border-dark').addClass('border-danger');
        UsernameFields = false;
        return;
    }

    // Check if the username is available with authentication
    $.ajax({
        url: 'http://127.0.0.1/api/v1/users/' + encodeURI(username) + '/check-username',
        method: 'GET',
        success: function (response) {
            if (response.exists) {
                $('#usernameHelp').addClass('text-danger').text('Username already in use.');
                $('#username').removeClass('border-dark').addClass('border-danger'); // Change border color to red for existing username
                UsernameFields = false;
            } else {
                $('#usernameHelp').text(''); // Display message if the username is available
                $('#username').removeClass('border-dark').addClass('border-success'); // Change border color to green for valid and available username
                UsernameFields = true;
            }
        },
        error: function (xhr, status, error) {
            $('#usernameHelp').addClass('text-danger').text('Error checking username availability');
            $('#username').removeClass('border-dark').addClass('border-danger'); // Change border color to red for error
        }
    });
}


function CheckEmail() {
    var email = $(this).val();

    // Check if the email is empty
    if (!email.trim()) {
        $('#emailHelp').text('');
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }

    // Check if the email is a valid email format
    if (!isValidEmail(email)) {
        $('#emailHelp').addClass('text-danger').text('Invalid email format');
        $(this).removeClass('border-dark').addClass('border-danger'); // Change border color to red for invalid email
        return; // Exit the function early if email is invalid
    } else {
        $('#emailHelp').text(''); // Clear the help text if the email is valid format
        $(this).removeClass('border-danger'); // Remove the border-danger class if present
    }

    // Check if the email is available with authentication
    $.ajax({
        url: 'http://127.0.0.1/api/v1/users/' + encodeURI(email) + '/check-email',
        method: 'GET',
        success: function (response) {
            if (response.exists) {
                $('#emailHelp').addClass('text-danger').text(response.message);
                $('#email').removeClass('border-dark').addClass('border-danger'); // Change border color to red for existing email
                EmailFields = false;
            } else {
                $('#emailHelp').text(''); // Display message if the email is available
                $('#email').removeClass('border-dark').addClass('border-success'); // Change border color to green for valid and available email
                EmailFields = true;
            }
        },
        error: function (xhr, status, error) {
            $('#emailHelp').addClass('text-danger').text('Error checking email availability');
            $('#email').removeClass('border-dark').addClass('border-danger'); // Change border color to red for error
        }
    });
}

function CheckPassword() {
    const password = $(this).val();

    // Check if the password is empty
    if (!password.trim()) {
        $('#passwordRequirment').text('');
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }
    const passwordRequirements = [{
        regex: /.{8,}/,
        message: '* Password must be at least 8 characters long.'
    },
    {
        regex: /[a-z]/,
        message: '* Password must contain at least one lowercase letter.'
    },
    {
        regex: /[A-Z]/,
        message: '* Password must contain at least one uppercase letter.'
    },
    {
        regex: /\d/,
        message: '* Password must contain at least one digit.'
    }
    ];

    const requirements = checkRequirements(password, passwordRequirements);
    updatePasswordRequirementsUI($(this), requirements['requirementsMet'], requirements['requirementsText']);
}

function updatePasswordRequirementsUI(passwordInput, requirementsMet, requirements) {
    if (requirementsMet) {
        $('#passwordRequirment').removeClass('text-danger').addClass('text-success').text('');
        passwordInput.removeClass('border-danger border-dark').addClass('border-success');
        PasswordFields = true;
    } else {
        $('#passwordRequirment').removeClass('text-success').addClass('text-danger').html(requirements);
        passwordInput.removeClass('border-success border-dark').addClass('border-danger');
        PasswordFields = false;
    }
}

function CheckConfirmPassword() {
    var password = $('#password').val();

    // Check if the password is empty
    if (!password.trim()) {
        $('#passwordHelp').text('');
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }

    var confirmPassword = $(this).val();

    if (password !== confirmPassword) {
        $('#passwordHelp').text('Passwords do not match');
        $(this).removeClass('border-success border-dark').addClass('border-danger');
        confirmPasswordFields = false;
    } else {
        $('#passwordHelp').text('');
        $(this).removeClass('border-danger border-dark').addClass('border-success');
        confirmPasswordFields = true;
    }
}

function ShowPassword() {
    var passwordField = $('#password');
    var confirmPasswordField = $('#confirmPassword');
    if ($(this).is(':checked')) {
        passwordField.attr('type', 'text');
        confirmPasswordField.attr('type', 'text');
    } else {
        passwordField.attr('type', 'password');
        confirmPasswordField.attr('type', 'password');
    }
}

function ValidEmail() {
    var email = $(this).val();

    // Check if the email is empty
    if (!email.trim()) {
        $('#emailHelp').text('');
        $(this).removeClass('border-success border-danger').addClass('border-dark');
        return; // Exit the function if email is empty
    }

    // Check if the email is a valid email format
    if (!isValidEmail(email)) {
        $('#emailHelp').addClass('text-danger').text('Invalid email format');
        $(this).removeClass('border-dark').addClass('border-danger'); // Change border color to red for invalid email
        return; // Exit the function early if email is invalid
    } else {
        $('#emailHelp').text(''); // Clear the help text if the email is valid format
        $(this).removeClass('border-danger border-dark').addClass('border-success'); // Remove the border-danger class if present
    }
}

function syncProfileBio() {
    const bioInput = $('#input-bio');
    const bioOutput = $('#profile-bio');
    const bioHelp = $('#bioHelp');

    const bio = bioInput.val().trim();
    bioHelp.text('').removeClass('text-danger');
    bioInput.removeClass('border-danger');

    if (!bio) {
        bioOutput.text('');
        return;
    }

    if (bio.length > 160) {
        bioHelp.text('* Bio must be at most 160 characters long').addClass('text-danger');
        bioInput.addClass('border-danger');
        bioInput.val(bio.substring(0, 160));
        return;
    }

    bioInput.addClass('border-success').removeClass('border-danger');
    bioOutput.text(bio);
}

function syncProfilePhoneNumber() {
    const phoneInput = $(this);
    const phoneHelp = $('#phoneHelp');

    let phone = phoneInput.val().trim();

    phoneHelp.text('').removeClass('text-danger');
    phoneInput.removeClass('border-danger border-success');

    // Check if the phone number is empty
    if (!phone) {
        phoneInput.removeClass('border-success border-danger');
        return;
    }

    // Check if the phone number starts with "+" and has 1 to 15 digits
    const regex = /^\+?\d{1,15}$/;

    if (!regex.test(phone)) {
        phoneHelp.text('* Phone number from 1 to 15 digits').addClass('text-danger');
        phoneInput.addClass('border-danger');
    } else {
        phoneInput.addClass('border-success');
    }

    // Remove non-digit characters and leading zeros
    phone = phone.replace(/[^\d]/g, '').replace(/^0*/, '');

    // Limit the input to 15 digits
    if (phone.length > 15) {
        phone = phone.substring(0, 15);
    }

    phoneInput.val(phone);
}

function syncProfileAge() {
    const ageInput = $(this);
    const ageHelp = $('#ageHelp');

    let age = ageInput.val().trim();

    ageHelp.text('').removeClass('text-danger');
    ageInput.removeClass('border-danger border-success');

    // Check if the phone number is empty
    if (!age) {
        ageInput.removeClass('border-success border-danger');
        return;
    }

    // Check if the phone number starts with "+" and has 1 to 15 digits
    const regex = /^\+?\d{1,3}$/;

    if (!regex.test(age)) {
        ageHelp.text('* Maximum age is 3 digits').addClass('text-danger');
        ageInput.addClass('border-danger');
    } else {
        ageInput.addClass('border-success');
    }

    // Remove non-digit characters and leading zeros
    age = age.replace(/[^\d]/g, '').replace(/^0*/, '');

    // Limit the input to 15 digits
    if (age.length > 3) {
        ageHelp.text('* Are fuc*ing serious? No more than 3 digits').addClass('text-danger');
        age = age.substring(0, 3);
    }

    ageInput.val(age);
}

function syncProfileName() {
    const nameInput = $(this);

    let name = nameInput.val().trim();

    nameInput.removeClass('border-danger border-success');

    // Check if the name is empty
    if (!name) {
        nameInput.removeClass('border-success border-danger');
        return;
    }

    // Check if name meets requirements of only letters and between 2 and 15 characters
    const nameRequirements = [
        {
            regex: /^[a-zA-Z]+$/,
            message: '* Name must only contain letters'
        },
        {
            regex: /^[a-zA-Z]{2,15}$/,
            message: '* Name must be between 2 and 15 characters long'
        }
    ];

    const requirements = checkRequirements(name, nameRequirements);

    // Update UI based on requirements met
    if (requirements['requirementsMet']) {
        nameInput.removeClass('border-danger border-dark').addClass('border-success');
    } else {
        nameInput.removeClass('border-success border-dark').addClass('border-danger');
    }

    nameInput.val(name);
}

function syncProfileAddress() {
    const addressInput = $(this);
    const addressHelp = $('#addressHelp');

    let address = addressInput.val().trim();

    addressHelp.text('').removeClass('text-danger');
    addressInput.removeClass('border-danger border-success');

    // Check if the address is empty
    if (!address) {
        addressInput.removeClass('border-success border-danger');
        return;
    }

    // Max address length 60
    if (address.length > 60) {
        address = address.substring(0, 60);
        addressHelp.text('* Address cannot be longer than 60 characters').addClass('text-danger');
        addressInput.addClass('border-danger');
    }

    addressInput.addClass('border-success');
    addressInput.val(address);
}


function VerifyVerifiedCode() {
    const numberInput = $(this);
    const numberHelp = $('#numberHelp');

    let number = numberInput.val().trim();

    numberHelp.text('').removeClass('text-danger');
    numberInput.removeClass('border-danger border-success');

    // Check if the phone number is empty
    if (!number) {
        numberInput.removeClass('border-success border-danger');
        return;
    }

    // Check if the phone number starts with "+" and has 1 to 15 digits
    const regex = /^\+?\d{1,8}$/;

    if (!regex.test(number)) {
        numberHelp.text('* Verified codes must be between 1-8 digits.').addClass('text-danger');
        numberInput.addClass('border-danger');
    } else {
        numberInput.addClass('border-success');
    }

    // Remove non-digit characters and leading zeros
    number = number.replace(/[^\d]/g, '').replace(/^0*/, '');

    // Limit the input to 15 digits
    if (number.length > 8) {
        numberHelp.text('* Maximum Verified codes is 8 digits.').addClass('text-danger');
        number = number.substring(0, 8);
    }

    numberInput.val(number);
}