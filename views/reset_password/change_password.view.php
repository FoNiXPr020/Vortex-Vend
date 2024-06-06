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
</head>

<body>

    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="pt-5 bg-dark">
        <div class="container py-4 px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-white display-5 mb-2 fw-bold">Reset Password</h1>
                    <p class="lead text-white-50 m-0">You will be able to change your password using this form by entering your email.</p>
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
        <h1 class="d-none">W3</h1>
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <div class="bg-white rounded shadow-sm p-4">
                                <form class="p-2" action="/reset-password/<?= $token ?>" method="POST">
                                    <?php
                                    Validation::setMethod("POST");
                                    Validation::generateCsrfToken();
                                    ?>
                                    <div class="mb-3">
                                        <label for="password" class="form-label text-dark">Password: <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control border-dark rounded-lg bg-light" placeholder="Enter your password" id="password">
                                        <div class="mt-2">
                                            <small id="passwordRequirment" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label text-dark">Confirm Password: <span class="text-danger">*</span></label>
                                        <input type="password" name="confirm_password" class="form-control border-dark rounded-lg bg-light" placeholder="Confirm your password" id="confirmPassword">
                                        <div class="mt-2">
                                            <small id="passwordHelp" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="showPassword">
                                            <label class="form-check-label text-dark" for="showPassword">
                                                Show Password
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" id="resetPassword" class="btn btn-primary btn-lg shadow-sm">Reset my password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#password').on('input', CheckPassword);
            $('#confirmPassword').on('input', CheckConfirmPassword);
            $('#showPassword').on('change', ShowPassword);
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