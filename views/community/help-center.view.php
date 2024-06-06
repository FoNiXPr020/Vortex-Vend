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
                    <h1 class="text-white display-5 mb-2 fw-bold">Help Center</h1>
                    <p class="lead text-white-50 m-0">We're here to help.</p>
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
            <div class="row justify-content-center g-4">
                <div class="col-lg-10 col-12">
                    <ul class="nav help-tabs mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active shadow-sm" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                <span class="text-center px-0 px-md-3 d-flex align-item-center flex-column">
                                    <span class="mb-2"><i class="bi bi-book fs-3"></i></span>
                                    <span class="h6 fw-bold">Vortex Vend</span>
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link shadow-sm" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                                <span class="text-center px-0 px-md-3 d-flex align-item-center flex-column">
                                    <span class="mb-2"><i class="bi bi-credit-card fs-3"></i></span>
                                    <span class="h6 fw-bold">Payment Methods</span>
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link shadow-sm" id="pills-selling-tab" data-bs-toggle="pill" data-bs-target="#pills-selling" type="button" role="tab" aria-controls="pills-selling" aria-selected="false">
                                <span class="text-center px-0 px-md-3 d-flex align-item-center flex-column">
                                    <span class="mb-2"><i class="bi bi-bag fs-3"></i></span>
                                    <span class="h6 fw-bold">Selling Prods</span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-6 mb-2">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="text-center fw-bold h2 mb-4">Getting Started</div>

                            <div class="accordion accordion-flush rounded shadow-sm overflow-hidden" id="accordionFlushExample">

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            What is a Vertex Vend?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">Vortex Vend is a product selling platform that offers a wide range of products. From electronics to clothing, you can find everything you need.</div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            How do I sign up for Vertex Vend?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            To Sing up or access existing account of Vortex Vend, you can visit the <a href="/login" class="text-decoration-none fw-bold text-primary">Login</a> and <a href="/register" class="text-decoration-none fw-bold text-primary">Register</a> sections.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            How do I change my Password?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            If you have access to your account, you can change your password by visiting <a href="/account" class="text-decoration-none fw-bold text-primary">Settings</a> section. If you have forgotten your password, you can reset it by visiting <a href="/forgot-password" class="text-decoration-none fw-bold text-primary">Forgot Password</a>.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                            How do I change my Email?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            You can change your email address by contacting us in the <a href="/contact" class="text-decoration-none fw-bold text-primary">Contact</a> section. Only the administration of this platform can change your email address.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingFive">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                            Can I sell used products?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">Used products are not allowed in this platform. Please contact us in the <a href="/contact" class="text-decoration-none fw-bold text-primary">Contact</a> section. for more information about used products.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="text-center fw-bold h2 mb-4">Payment Methods</div>

                            <div class="accordion accordion-flush rounded shadow-sm overflow-hidden" id="accordionFlushExample3">

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingElevan">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseElevan" aria-expanded="false" aria-controls="flush-collapseElevan">
                                            What is a payments method?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseElevan" class="accordion-collapse collapse" aria-labelledby="flush-headingElevan" data-bs-parent="#accordionFlushExample3">
                                        <div class="accordion-body text-muted">Vertex Vend currently only accepts payments via PayPal.</div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingTwelve">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwelve" aria-expanded="false" aria-controls="flush-collapseTwelve">
                                            Why Vertex only accepts payments via PayPal?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseTwelve" class="accordion-collapse collapse" aria-labelledby="flush-headingTwelve" data-bs-parent="#accordionFlushExample3">
                                        <div class="accordion-body text-muted">PayPal is a secure online payment system that allows you to send and receive online payments quickly and easily.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingThirteen">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThirteen" aria-expanded="false" aria-controls="flush-collapseThirteen">
                                            Does Vertex accept credit cards?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseThirteen" class="accordion-collapse collapse" aria-labelledby="flush-headingThirteen" data-bs-parent="#accordionFlushExample3">
                                        <div class="accordion-body text-muted">
                                        Yes Vertex accepts credit cards by paying via PayPal. It is a popular payment method worldwide used by millions of people online. You can use your PayPal account to pay for products and services on the Vertex Vend platform.
                                    </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingFifteen">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFifteen" aria-expanded="false" aria-controls="flush-collapseFifteen">
                                            How do I make a payment with Vertex?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseFifteen" class="accordion-collapse collapse" aria-labelledby="flush-headingFifteen" data-bs-parent="#accordionFlushExample3">
                                        <div class="accordion-body text-muted">To make a payment, you simply click the PayPal button and follow the instructions provided by PayPal. Once you have made a payment, you will be able to access the product or service you have purchased.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-selling" role="tabpanel" aria-labelledby="pills-selling-tab">
                            <div class="text-center fw-bold h2 mb-4">Selling Prods</div>

                            <div class="accordion accordion-flush rounded shadow-sm overflow-hidden" id="accordionFlushExample4">

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingSeventeen">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeventeen" aria-expanded="false" aria-controls="flush-collapseSeventeen">
                                            It is allowed to sell already used Prods?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="flush-headingSeventeen" data-bs-parent="#accordionFlushExample4">
                                        <div class="accordion-body text-muted">No, it is not allowed to sell already used Prods. we only accept new Prods.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingEighteen">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEighteen" aria-expanded="false" aria-controls="flush-collapseEighteen">
                                            Can i create a product without verified account?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseEighteen" class="accordion-collapse collapse" aria-labelledby="flush-headingEighteen" data-bs-parent="#accordionFlushExample4">
                                        <div class="accordion-body text-muted">Unfortunately, it is not possible to create a product without verified account. Please verify your account. in the account <a href="/account" class="text-decoration-none fw-bold text-primary">Settings</a> section.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingNineteen">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNineteen" aria-expanded="false" aria-controls="flush-collapseNineteen">
                                            What happed if i had refund my Prods?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseNineteen" class="accordion-collapse collapse" aria-labelledby="flush-headingNineteen" data-bs-parent="#accordionFlushExample4">
                                        <div class="accordion-body text-muted">We do not accept refunds. We will refund your money if you return the product in good condition.</div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="flush-headingTwenty">
                                        <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwenty" aria-expanded="false" aria-controls="flush-collapseTwenty">
                                            Does Vertex accept digital assets?
                                        </button>
                                    </h1>
                                    <div id="flush-collapseTwenty" class="accordion-collapse collapse" aria-labelledby="flush-headingTwenty" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">Yes, we will accept digital assets soon. We will not accept any other type of assets except the ones listed above.
                                        </div>
                                    </div>
                                </div>
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