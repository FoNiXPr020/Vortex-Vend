$(document).ready(function () {
    var followerId = $('#followBtn').data('follower-id');

    $('#followBtn').click(function () {
        var action = $(this).data('action');
        var url = action === 'follow' ? '/api/v1/follow/' : '/api/v1/unfollow/';

        // Perform the AJAX request
        $.ajax({
            url: url + followerId,
            type: 'POST',
            success: function (response) {
                if (response.message == 'Followed' || response.message == 'Unfollowed') {
                    checkFollowStatus();
                }
            }
        });
    });

    function checkFollowStatus() {
        $.ajax({
            url: '/api/v1/follow/status/' + followerId,
            type: 'GET',
            success: function (response) {
                if (response.is_following) {
                    $('#followBtn').data('action', 'unfollow').text('Unfollow');
                } else {
                    $('#followBtn').data('action', 'follow').text('Follow');
                }
            }
        });
    }
    // Initial load
    checkFollowStatus();

    var copyLinks = document.querySelectorAll('.copy-link');

    copyLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            var fullLink = this.getAttribute('fulllink');

            // Create a temporary input element
            var tempInput = document.createElement('input');
            tempInput.value = fullLink;
            document.body.appendChild(tempInput);

            // Select the text in the input element
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); /*For mobile devices*/

            // Copy the text to the clipboard
            document.execCommand('copy');

            // Remove the temporary input element
            document.body.removeChild(tempInput);

            // Change the icon to indicate success
            var icon = this.querySelector('i');
            icon.classList.remove('bi-clipboard-fill');
            icon.classList.add('text-success', 'bi-clipboard-check-fill');

            // Gradually fade the icon back in after 3 seconds
            setTimeout(function () {
                icon.classList.remove('text-success', 'bi-clipboard-check-fill');
                icon.classList.add('bi-clipboard-fill');
            }, 3000);
        });
    });
});