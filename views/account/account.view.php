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
                    <h1 class="text-white display-5 mb-2 fw-bold">Account Settings</h1>
                    <p class="lead text-white-50 m-0">Update your account information</p>
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
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">

                    <div class="rounded bg-white p-3 mb-3 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <h6 class="fw-bold mb-1">Account details</h6>
                                <p class="text-muted">Update your account security details here</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-<?= isset($user['verified']) && $user['verified'] == 1 ? 'success' : 'warning'; ?> btn-sm" data-bs-toggle="modal" data-bs-target="#VerifyModal"><?= isset($user['verified']) && $user['verified'] == 1 ? 'Verified' : 'Unverified'; ?></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= isset($user['username']) ? $user['username'] : '' ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="text" class="form-control" value="<?= isset($user['email_address']) ? $user['email_address'] : '' ?>" disabled>
                        </div>
                    </div>

                    <div class="rounded bg-white mb-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center form-check form-switch p-3 border-bottom">
                            <div>
                                <label class="form-check-label d-flex flex-column" for="flexSwitchPrivateAccount">
                                    <span class="fw-bold mb-1 h6">Customers Privacy</span>
                                    <span class="text-muted small">Choose whether you want your account to be visible or hidden from the public</span>
                                </label>
                            </div>
                            <div class="h5 m-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="flexSwitchPrivateAccount" <?= $user['customers_status'] == "private" ? 'checked' : '' ?>>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center form-check form-switch p-3 border-bottom">
                            <div>
                                <label class="form-check-label d-flex flex-column" for="flexSwitchFollowers">
                                    <span class="fw-bold mb-1 h6">Followers Privacy</span>
                                    <span class="text-muted small">Would you like guests to see your followers profile?</span>
                                </label>
                            </div>
                            <div class="h5 m-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="flexSwitchFollowers" <?= $user['followers_status'] == "private" ? 'checked' : '' ?>>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center form-check form-switch p-3 border-bottom">
                            <div>
                                <label class="form-check-label d-flex flex-column" for="flexSwitchFollowing">
                                    <span class="fw-bold mb-1 h6">Following Privacy</span>
                                    <span class="text-muted small">Would you like guests to see who are you following?</span>
                                </label>
                            </div>
                            <div class="h5 m-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="flexSwitchFollowing" <?= $user['following_status'] == "private" ? 'checked' : '' ?>>
                            </div>
                        </div>
                    </div>

                    <div class="rounded bg-white p-3 mb-3 shadow-sm">
                        <form action="/account" method="POST">
                            <?php
                            Validation::setMethod("POST");
                            Validation::generateCsrfToken();
                            ?>
                            <div class="mb-3">
                                <h6 class="fw-bold mb-1">Update Password</h6>
                                <p class="text-muted">Update your account password security details here!</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Current Password <small class="text-danger">*</small></label>
                                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Enter your current password">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">New Password <small class="text-danger">*</small></label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your new password">
                                    <div class="mt-2">
                                        <small id="passwordRequirment" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">Confirm Password <small class="text-danger">*</small></label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Confirm your new password">
                                    <div class="mt-2">
                                        <small id="passwordHelp" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="showPassword">
                                    <label class="form-check-label text-dark" for="showPassword">
                                        Show Password
                                    </label>
                                </div>
                                <div><a href="/reset-password" class="text-decoration-none text-primary">Recover Password?</a></div>
                            </div>
                            <div class="mt-2 mb-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary w-100" id="update_password">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ( $user['verified'] != 1 ) : ?>
    <!-- Verify Modal -->
    <div class="modal fade" id="VerifyModal" tabindex="-1" aria-labelledby="VerifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="VerifyModalLabel">Account Verification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>Verify your account now by clicking 'Verify Now'. This will send you a special activation code via email, unlocking all the purchase sections and features.
                    <br>Email : <strong><?= $user['email_address'] ?></strong>
                </div>
                </div>
                <div class="modal-footer">
                    <form action="/send-verification" method="POST">
                        <?php
                        Validation::setMethod("POST");
                        Validation::generateCsrfToken();
                        ?>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success btn-sm ms-2">Verify Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script src="<?php assets('js/account.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#flexSwitchPrivateAccount').change(PrivateAccount);
            $('#flexSwitchFollowers').change(PrivateFollowers);
            $('#flexSwitchFollowing').change(PrivateFollowing);

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