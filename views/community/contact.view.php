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
                    <h1 class="text-white display-5 mb-2 fw-bold">Contact Us</h1>
                    <p class="lead text-white-50 m-0">Have any questions? We'd love to hear from you.</p>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-light">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="#f0f2f5">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>

    <section class="py-5 text-center">
        <div class="container">
            <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5">
                <div class="col">
                    <div class="feature bg-success bg-gradient text-white rounded-pill mb-3"><i class="icofont-chat"></i></div>
                    <div class="h5 mb-2 fw-bold text-black">Chat with us</div>
                    <p class="text-muted mb-0">Chat live with one of our support specialists.</p>
                </div>
                <div class="col">
                    <div class="feature bg-success bg-gradient text-white rounded-pill mb-3"><i class="icofont-people"></i></div>
                    <div class="h5 fw-bold text-black">Ask the community</div>
                    <p class="text-muted mb-0">Explore our community forums and communicate with other users.</p>
                </div>
                <div class="col">
                    <div class="feature bg-success bg-gradient text-white rounded-pill mb-3"><i class="icofont-question-circle"></i></div>
                    <div class="h5 fw-bold text-black">Support center</div>
                    <p class="text-muted mb-0">Browse FAQ's and support articles to find solutions.</p>
                </div>
                <div class="col">
                    <div class="feature bg-success bg-gradient text-white rounded-pill mb-3"><i class="icofont-telephone"></i></div>
                    <div class="h5 fw-bold text-black">Call us</div>
                    <p class="text-muted mb-0">Call us during normal business hours at (555) 892-9403.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14101993.833511807!2d-26.456151689921498!3d30.35465600184366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b88619651c58d%3A0xd9d39381c42cffc3!2sMorocco!5e0!3m2!1sen!2sma!4v1717445117922!5m2!1sen!2sma" class="border-0 w-100" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-6">
                    <div class="pe-lg-5">
                        <div class="pe-lg-5">
                            <div class="py-5">
                                <div class="display-5 text-dark fw-bold mb-2">Get In Touch.</div>
                                <p class="pt-1 pb-3 lead">Fill in the form to the right to get in touch with someone on our team, and we will reach out shortly.</p>
                                <form class="row g-3" action="/contact" method="POST">
                                    <?php
                                    Validation::setMethod('POST');
                                    Validation::generateCsrfToken();
                                    ?>
                                    <div class="d-flex gap-3 justify-content-between">
                                        <div class="w-100">
                                            <input type="text" name="email" class="form-control" placeholder="Enter Your Email Address" aria-label="Recipient's email">
                                        </div>
                                        <div class="w-100">
                                            <input type="text" name="about" class="form-control" placeholder="Enter Subject" aria-label="Recipient's subject">
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <textarea class="form-control" name="message" placeholder="Message" rows="6"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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