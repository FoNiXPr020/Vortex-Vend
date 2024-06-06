
function getBaseURL() {
    var baseURL = window.location.protocol + '//' + window.location.hostname;
    if (window.location.port) {
        baseURL += ':' + window.location.port;
    }
    return baseURL;
}

function PrivateAccount() {
    // Get the current status
    var status = $(this).prop('checked') ? 'private' : 'public';

    $.ajax({
        url: getBaseURL() + '/api/v1/account/status/customer',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            status: status
        }),
        dataType: 'json',
        success: function (response) {
            if (response.status === 200) {
                displayToast("success", response.message);
            } else {
                displayToast("error", response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            console.log('Response: ' + xhr.responseText);
        }
    });
}

function PrivateFollowers() {
    // Get the current status
    var status = $(this).prop('checked') ? 'private' : 'public';

    $.ajax({
        url: getBaseURL() + '/api/v1/account/status/followers',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            status: status
        }),
        dataType: 'json',
        success: function (response) {
            if (response.status === 200) {
                displayToast("success", response.message);
            } else {
                displayToast("error", response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            console.log('Response: ' + xhr.responseText);
        }
    });
}

function PrivateFollowing() {
    // Get the current status
    var status = $(this).prop('checked') ? 'private' : 'public';

    $.ajax({
        url: getBaseURL() + '/api/v1/account/status/following',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            status: status
        }),
        dataType: 'json',
        success: function (response) {
            if (response.status === 200) {
                displayToast("success", response.message);
            } else {
                displayToast("error", response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            console.log('Response: ' + xhr.responseText);
        }
    });
}