$(document).ready(function() {

    $('#username').on('input', CheckUsername);
    $('#input-bio').on('input', syncProfileBio);
    $('#input-age').on('input', syncProfileAge);
    $('#input-address').on('input', syncProfileAddress);
    $('#phone-number').on('input', syncProfilePhoneNumber);
    $('#firstName').on('input', syncProfileName);
    $('#lastName').on('input', syncProfileName);
});