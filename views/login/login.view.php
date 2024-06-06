<?php

use Core\Translator;
use Core\Validation;

?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
</head>
<body>
    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="pt-5 bg-dark">
        <div class="container py-4 px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-white display-5 mb-2 fw-bold">Login</h1>
                    <p class="lead text-white-50 m-0">Welcome back to our marketplace! Please sign in to continue.</p>
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
                <div class="col-lg-4 col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <form class="p-2" action="/login" method="POST">
                            <?php
                            Validation::setMethod("POST");
                            Validation::generateCsrfToken();
                            ?>
                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label text-dark">Email: <span class="text-danger">*</span></label>
                                <input type="email" name="email_address" id="email" class="form-control border-dark rounded-lg bg-light" placeholder="Enter your email" value="<?php echo isset($data['email_address']) ? $data['email_address'] : ''; ?>">
                                <div class="mt-2">
                                    <small id="emailHelp" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-dark">Password: <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control border-dark rounded-lg bg-light" placeholder="Enter your password" id="password">
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="showPassword">
                                    <label class="form-check-label text-dark" for="showPassword">
                                        Show Password
                                    </label>
                                </div>
                                <div><a href="/forgot-password" class="text-decoration-none text-primary">Forget Password?</a></div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg shadow-sm">Login</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-between divide my-3">
                                <hr class="w-100">
                                <span class="text-muted small px-2">OR</span>
                                <hr class="w-100">
                            </div>
                            <div class="d-flex gap-4 justify-content-center fs-5 login-with-social">
                                <div id="g_id_onload" data-client_id="1013532138737-3p0ugr8n1q20fgd7le5m01vkr56lhb59.apps.googleusercontent.com" data-context="signin" data-ux_mode="popup" data-login_uri="http://localhost/login/confirmation" data-auto_prompt="false">
                                </div>

                                <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="filled_black" data-text="signin_with" data-size="large" data-logo_alignment="left">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-4">
                        <div>Don't have an account? <a href="/register" class="text-decoration-none text-primary">Create an account</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Functions to validate login
            $('#email').on('input', ValidEmail);
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