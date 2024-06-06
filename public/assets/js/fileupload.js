var cropper;
var canvas;
var maxFileSize = 2.5 * 1024 * 1024; // 2.5 MB

$('#file-upload').on('change', function (e) {
    var files = e.target.files;
    var file = files[0];

    if (file.size > maxFileSize) {
        $('#file-name').text("File size exceeds 2.5 MB. Please choose a smaller file.").removeClass('text-success text-muted').addClass('text-danger');
        $('#file-preview').removeClass('border-success border-dark').addClass('border-danger');
        return;
    }
    var done = function (url) {
        $('#image-to-crop').attr('src', url);
        $('#cropModal').modal('show');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$('#cropModal').on('shown.bs.modal', function () {
    cropper = new Cropper(document.getElementById('image-to-crop'), {
        aspectRatio: 1,
        viewMode: 3,
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
});

$('#crop-button').on('click', function () {
    canvas = cropper.getCroppedCanvas({
        width: 256,
        height: 256,
    });

    canvas.toBlob(function (blob) {
        // Create a new File object from the Blob
        var file = new File([blob], "cropped_image.jpg", { type: "image/jpeg" });

        // Create a new DataTransfer object
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        // Assign the File object to the file input
        $('#file-upload')[0].files = dataTransfer.files;

        // Update the profile picture preview
        var url = URL.createObjectURL(blob);
        $('#profile-pic').attr('src', url);
        $('#file-name').text("Picture successfully customized").removeClass('text-danger text-muted').addClass('text-success');
        $('#file-preview').removeClass('border-danger border-dark').addClass('border-success');
        // Clear the canvas
        canvas = null;

        // Hide the modal
        $('#cropModal').modal('hide');
    });
});