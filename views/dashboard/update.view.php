<?php

use Core\Translator;
use Core\Validation;

?>

<!doctype html>
<html lang="en">

<head>
    <?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
    <style>
        .img-upload {
            position: relative;
            width: 80%;
            height: 300px;
            overflow: hidden;
            display: flex;
            justify-content: space-around;
            align-items: stretch;
            flex-direction: column-reverse;
            flex-wrap: nowrap;
        }

        .img-upload img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .img-upload .edit-button {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            height: 20%;
            transform: translate(-50%, -50%);
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .img-upload {
                width: 100%;
            }

            .img-upload img {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="pt-5 bg-dark">
        <div class="container py-4 px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-white display-5 mb-2 fw-bold">Update Product</h1>
                    <p class="lead text-white-50 m-0">Always be up to date with your products. Quickly and easily update product details here.</p>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-light">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="#f0f2f5">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="row">
                        <div class="col-lg-8 pe-lg-5">
                            <div>
                                <form action="/update-product/<?= $product['id'] ?>" id="create-product-form" method="POST" enctype="multipart/form-data">
                                    <?php
                                    Validation::setMethod("PUT");
                                    Validation::generateCsrfToken();
                                    ?>
                                    <div class="rounded bg-white p-3 mb-3 shadow-sm">
                                        <div class="mb-3">
                                            <h6 class="fw-bold mb-1">Update Product</h6>
                                            <p class="text-muted">Fill the form below to update your product.</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Product Name</label>
                                            <input type="text" class="form-control" name="title" id="Titleinput" placeholder="e.g. Vortex Vend" aria-label="Title" value="<?= isset($data['title']) ? $data['title'] : $product['name'] ?>">
                                            <div class="mt-2 ms-2" id="titleHelp"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="description" id="Descriptioninput" placeholder="e.g. About Vortex Vend is a platform where you can sell and buy products..." aria-label="Description" value="<?= isset($data['description']) ? $data['description'] : $product['description'] ?>">
                                            <div class="mt-2 ms-2" id="descriptionHelp"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Price</label>
                                                <input type="text" class="form-control" name="price" id="Priceinput" placeholder="e.g. 10.99" aria-label="Price" value="<?= isset($data['price']) ? $data['price'] : $product['price'] ?>">
                                                <div class="mt-2 ms-2" id="priceHelp"></div>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" class="form-control" name="quantity" id="Quantityinput" placeholder="e.g. 1" aria-label="Quantity" value="<?= isset($data['quantity']) ? $data['quantity'] : $product['quantity'] ?>">
                                                <div class="mt-2 ms-2" id="quantityHelp"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-3">Upload Picture</h6>
                                    <p class="text-muted">Drag or choose your profile picture to upload.</p>
                                    <div class="mt-2 mb-2 ms-2 text-center" id="imageHelp"></div>
                                    <div class="row justify-content-center">
                                        <div class="border border-0 mb-3 rounded img-upload">
                                            <input type="file" name="image" id="fileInput" class="d-none" accept="image/png, image/jpeg">
                                            <img src="<?php echo isset($product['image']) ? $product['image'] : $_ENV['APP_DEFAULT_PRODUCT_IMG'] ?>" id="imgUploadPreview" alt="Image Preview">
                                        </div>
                                    </div>
                                    <div class="mb-2 text-center">
                                        <button type="button" class="btn btn-success border-0 rounded fw-bold edit-button text-white" id="uploadButton">
                                            <i class="bi bi-cloud-upload"></i>&nbsp;Change Picture
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-3">
                            <div class="sidebar-fix">
                                <h6 class="fw-bold">Preview</h6>
                                <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                    <div class="card-header border-0 bg-white p-0 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div><img src="<?= isset($user['profile_img']) ? $user['profile_img'] : $_ENV['APP_DEFAULT_PROFILE_IMG'] ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                <div class="fw-bold"><?= $user['username'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <img id="imgPreview" src="<?php echo isset($product['image']) ? $product['image'] : $_ENV['APP_DEFAULT_PRODUCT_IMG'] ?>" alt="#" class="card-img-top rounded-lg">
                                    <div class="card-body fw-bold px-0 pb-0">
                                        <h5 class="card-title fw-bold mb-2 preview-title">Vortex Vend
                                        </h5>
                                        <p class="card-text text-muted mb-2 preview-description"><small class="text-muted">Vertex Vend are a platform where you can sell and buy products</small></p>
                                        <div class="text-muted">
                                            Price
                                            <span class="preview-price text-success">19.10$ </span>
                                            / Quantity :
                                            <span class="preview-quantity text-primary"> 1</span>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($product['status'] != "sold") :?>
                                <div class="mt-4">
                                    <div><button type="submit" class="btn btn-success btn-lg rounded w-100" id="createButton">Update Product</button></div>
                                </div>
                                <?php else : ?>
                                <div class="mt-4">
                                    <div><button type="button" class="btn btn-outline-danger btn-lg rounded w-100" disabled>Already Sold</button></div>
                                </div>
                                <?php endif; ?>
                                <div class="mt-2">
                                    <div><button class="btn btn-danger btn-lg rounded w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Product</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="/delete-product/<?= $product['id'] ?>" method="post">
                        <?php
                        Validation::setMethod("DELETE");
                        Validation::generateCsrfToken();
                        ?>
                        <input type="hidden" name="id" id="deleteProductId" value="<?= $product['id'] ?>">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script src="<?php assets('js/product.js'); ?>"></script>
    <script>
        $(document).ready(function() {

            $('#createButton').prop('disabled', true);

            // Form submission
            $('#createButton').on('click', function() {

                // Check if image is uploaded
                if ($('#imgUploadPreview').attr('src') === 'assets/img/products/default-product.jpg') {
                    $('#imageHelp').html('<small class="form-text text-danger mb-5">* Please upload an image.</small>');
                    return;
                }

                $('#create-product-form').submit();
            });
            // Image upload
            $('#uploadButton').on('click', function() {
                $('#fileInput').click();
            });

            $('#fileInput').on('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
                    $('#imageHelp').html('');
                    if (!allowedTypes.includes(file.type)) {
                        $('#imageHelp').html('<small class="form-text text-danger mb-5">* Invalid file type. Only PNG, JPG, and JPEG files are allowed.</small>');
                        return;
                    }

                    // Check file size limit of 2.5 MB
                    var maxSize = 2.5 * 1024 * 1024; // 2.5 MB
                    if (file.size > maxSize) {
                        $('#imageHelp').html('<small class="form-text text-danger mb-5">* File size exceeds the limit of 2.5 MB.</small>');
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imgUploadPreview').attr('src', e.target.result).show();
                        $('#imgPreview').attr('src', e.target.result); // Update the preview image
                        updatePreview(); // Update the preview section
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Title input validation
            $('#Titleinput').on('input', Titelinput);
            $('#Descriptioninput').on('input', Descriptioninput);
            $('#Quantityinput').on('input', Quantityinputvalidation);
            $('#Priceinput').on('input', Priceinput);

            // Listen for input changes in the form fields
            $('input[name="title"], input[name="description"], input[name="price"], input[name="quantity"]').on('input', updatePreview);
            updatePreview();
        });
    </script>

    <?php
    if (!empty($errors)) {
        displayToast('error', $errors);
    }
    if (!empty($success)) {
        displayToast('success', $success);
    }
    ?>
</body>

</html>