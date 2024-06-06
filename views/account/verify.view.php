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
                    <h1 class="text-white display-5 mb-2 fw-bold">Account Verification</h1>
                    <p class="lead text-white-50 m-0">Welcome to verify Account section. Check your email for the verification code.</p>
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
                                <form class="p-2" action="/verification" method="POST">
                                    <?php
                                    Validation::setMethod("POST");
                                    Validation::generateCsrfToken();
                                    ?>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Verification Code:&nbsp;<span class="text-danger">*</span></label>
                                        <input type="text" name="verification_code" id="verification_code" class="form-control rounded-lg bg-light" placeholder="Verification Code">
                                        <div class="mt-2">
                                            <small id="numberHelp" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="text-muted"> You didn't receive any code?
                                        </div>
                                        <div>
                                            <a class="text-decoration-none text-primary" id="resendcode" role="button">Resend Code</a>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" id="verifyaccount" class="btn btn-primary btn-lg shadow-sm">Verify Account</button>
                                    </div>
                                </form>
                                <form class="p-2" action="/send-verification" method="POST" id="send-verification">
                                    <?php
                                    Validation::setMethod("POST");
                                    Validation::generateCsrfToken();
                                    ?>
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
            // Functions to validate login
            $('#verification_code').on('input', VerifyVerifiedCode);
            // Form submission
            $('#resendcode').on('click', function() {
                $('#send-verification').submit();
            });
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