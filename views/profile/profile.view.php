<?php

use Core\Functions;
use Core\Translator;
use Core\Validation;
use Core\App;
use Core\Session;

?>

<!doctype html>
<html lang="en">

<head>
    <?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php assets('css/profile.css'); ?>" type="text/css" />
</head>

<body>

    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="pt-5 bg-dark">
        <div class="container py-4 px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-white display-5 mb-2 fw-bold">Profile</h1>
                    <p class="lead text-white-50 m-0">Here you can view and edit your profile information.</p>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-light">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="#f0f2f5">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 py-5">
                    <div class="rounded shadow-osahan bg-white card border-0 author-sidebar">
                        <div class="p-3">
                            <div class="card-body text-center">
                                <div>
                                    <img id="profile-pic" src="<?= $user['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle border border-5 border-white mb-3 shadow-sm">
                                </div>
                                <h3 id="profile-name" class="card-title text-dark fw-bold mb-1"><?= $user['first_name'] ? ($user['first_name'] . ' ' . $user['last_name']) : $user['username']; ?></h3>
                                <p id="profile-username" class="card-text text-muted">@<?= strtolower($user['username']) ?? 'Unknown'; ?></p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center border-top border-bottom">
                            <div class="text-center p-4">
                                <h5 class="fw-bold mb-0"><?= count($products) ?? 0; ?></h5>
                                <div class="text-muted small">Prods</div>
                            </div>
                            <div class="border-start"></div>
                            <div class="text-center p-4">
                                <h5 class="fw-bold mb-0"><?= count($sales) ?? 0; ?></h5>
                                <div class="text-muted small">Sales</div>
                            </div>
                            <div class="border-end"></div>
                            <div class="text-center p-4">
                                <h5 class="fw-bold mb-0"><?= count($followers) ?? 0; ?></h5>
                                <div class="text-muted small">Followers</div>
                            </div>
                        </div>
                        <div id="profile-bio" class="text-center p-4"><?= $user['profile_bio'] ?? $_ENV['APP_PROFILE_BIO']; ?></div>
                    </div>
                </div>
                <div class="col-12 col-lg-9 ps-lg-5 mb-5">
                    <div class="rounded shadow-osahan bg-white">
                        <div class="py-3 border-bottom fw-bold h5 mt-5 ms-4 text-uppercase">Edit profile</div>
                        <div class="p-2 ms-3">
                            <form id="profile-form" method="POST" enctype="multipart/form-data" action="/profile">
                                <?php
                                Validation::setMethod("POST");
                                Validation::generateCsrfToken();
                                ?>
                                <div class="my-1">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input id="username" name="username" type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" value="<?= isset($data['username']) ? $data['username'] : $user['username'] ?>" required>
                                    </div>
                                    <div class="mt-2">
                                        <small id="usernameHelp" class="text-danger"></small>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col">
                                        <input id="firstName" name="first_name" type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= isset($data['first_name']) ? $data['first_name'] : $user['first_name'] ?>">
                                    </div>
                                    <div class="col">
                                        <input id="lastName" name="last_name" type="text" class="form-control" placeholder="Last name" aria-label="Last name" value="<?= isset($data['last_name']) ? $data['last_name'] : $user['last_name'] ?>">
                                    </div>
                                </div>
                                <div class="my-3">
                                    <input id="input-address" name="address" class="form-control" type="text" placeholder="Billing Address" aria-label="Billing Address" value="<?= isset($data['address']) ? $data['address'] : $user['address'] ?>">
                                    <div class="mt-2">
                                        <small id="addressHelp" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <input id="input-age" name="age" class="form-control" type="text" placeholder="Age" aria-label="Your Age" value="<?= isset($data['age']) ? $data['age'] : $user['age'] ?>">
                                    <div class="mt-2">
                                        <small id="ageHelp" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <input id="phone-number" name="phone_number" class="form-control" type="text" placeholder="Phone number" aria-label="Phone number" value="<?= isset($data['phone_number']) ? $data['phone_number'] : $user['phone_number'] ?>">
                                    <div class="mt-2">
                                        <small id="phoneHelp" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <input id="input-bio" name="profile_bio" class="form-control" type="text" placeholder="Profile bio (optional)" aria-label="Profile bio" value="<?= isset($data['profile_bio']) ? $data['profile_bio'] : $user['profile_bio'] ?>">
                                    <div class="mt-2">
                                        <small id="bioHelp" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12 my-3">
                                    <div id="file-preview" class="border text-center rounded px-3 py-4">
                                        <div id="file-name" class="small text-muted mb-3">(256x256) PNG or JPG. Max 2.5 MB.
                                        </div>
                                        <div>
                                            <label for="file-upload" class="btn btn-primary rounded-lg px-3">
                                                <span><i class="bi bi-cloud-upload"></i></span>&nbsp;Upload picture
                                            </label>
                                            <input id="file-upload" type="file" name="file-upload" accept=".png, .webp, .jpg, .jpeg" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid col-8 mt-3 mb-3 mx-auto">
                                    <button type="submit" id="save-changes" class="btn btn-primary rounded-lg fw-bold py-3">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for cropping -->
    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title h5 fw-bold" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image-to-crop" src="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop-button" class="btn btn-primary">Customize</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="<?php assets('js/fileupload.js'); ?>"></script>
    <script src="<?php assets('js/profile.js'); ?>"></script>
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