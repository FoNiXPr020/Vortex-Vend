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
                                <form class="p-2" action="/forgot-password" method="POST">
                                    <?php
                                    Validation::setMethod("POST");
                                    Validation::generateCsrfToken();
                                    ?>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email:&nbsp;<span class="text-danger">*</span></label>
                                        <input type="email" name="email_address" id="email" class="form-control rounded-lg bg-light" placeholder="Enter your email" value="<?php echo isset($data['email_address']) ? $data['email_address'] : ''; ?>">
                                        <div class="mt-2">
                                            <small id="emailHelp" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" id="resetPassword" class="btn btn-primary btn-lg shadow-sm">Reset my password</button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-center mt-4">
                                <div>Did you remember your password?&nbsp;<a href="/login" class="text-decoration-none text-primary">Sign in.</a></div>
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
            // Functions to validate login
            $('#email').on('input', ValidEmail);
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