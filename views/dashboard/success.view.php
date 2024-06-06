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
    <style>
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            pointer-events: none;
        }
    </style>
</head>

<body>

    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="pt-5 bg-dark">
        <div class="container py-4 px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-white display-5 mb-2 fw-bold">Thank you, <span class="text-success"><?= $user['username']; ?></span></h1>
                    <p class="lead text-white-50 m-0">Your order has been successfully placed</p>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-light">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="#f0f2f5">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>

    <section class="pt-5 bg-light">
        <div class="container py-4 px-5">
            <div class="row gx-5">
                <div class="col-lg-8 py-3">
                    <div class="sidebar-fix">
                        <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 py-1">
                            <h6 class="fw-bold"></h6>
                            <div class="card-body fw-bold">
                                <h5 class="card-title fw-bold">Congratulations!&nbsp;</h5>
                                <p class="card-text mb-0"><small class="text-muted">Your order has been successfully placed, and will be shipped to you</small></p>
                                <div class="text-primary mt-1"><span class="text-muted">Price :</span> $<?= $product['price'] ?? 0; ?> <span class="text-muted"> / Quntity :</span> <?= $product['quantity'] ?? 0; ?></div>
                            </div>
                        </div>
                        <form action="/payment/update" method="POST">
                            <?php
                            Validation::setMethod("POST");
                            Validation::generateCsrfToken();
                            ?>
                            <div class="rounded bg-white p-3 mb-3 mt-3 shadow-sm">

                                <div class="mb-3">
                                    <h6 class="fw-bold mb-1">Update Address <span class="text-muted">( Optional )</span></h6>
                                </div>
                                <div class="mb-3">
                                    <label for="input-address" class="form-label">Address</label>
                                    <input id="input-address" name="address" class="form-control" type="text" placeholder="Billing Address" aria-label="Billing Address" value="<?= $user['address'] ?? '' ?>">
                                    <div class="mt-2">
                                        <small id="addressHelp" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone-number" class="form-label">Phone number</label>
                                    <input id="phone-number" name="phone_number" class="form-control" type="text" placeholder="Phone number" aria-label="Phone number" value="<?= $user['phone_number'] ?? '' ?>">
                                    <div class="mt-2">
                                        <small id="phoneHelp" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div><button type="submit" class="btn btn-primary btn-lg rounded w-100">Update Shipping</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="sidebar-fix">
                        <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                            <div class="card-header border-0 bg-white p-0 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <div><img src="<?= $product['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                        <div class="fw-bold"><?= $product['seller_username'] ?? ''; ?></div>
                                    </div>
                                    <div class="like-btn"><a href="#" class="text-decoration-none link-dark"><i class="bi bi-share"></i></a></div>
                                </div>
                            </div>
                            <img src="<?= $product['image'] ?? $_ENV['APP_DEFAULT_PRODUCT_IMG']; ?>" alt="#" class="card-img-top rounded-lg">
                            <div class="card-body fw-bold px-0 pb-0">
                                <h5 class="card-title fw-bold mb-0"><?= $product['product_name'] ?? ''; ?></h5>
                                <p class="card-text mb-0"><small class="text-muted"><?= $product['description'] ?? ''; ?></small></p>
                                <div class="text-primary"><span class="text-muted">Price :</span> $<?= $product['price'] ?? 0; ?> <span class="text-muted"> / Quntity :</span> <?= $product['quantity'] ?? 0; ?></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <form action="/download-invoice" method="POST">
                                <?php
                                Validation::setMethod("PATCH");
                                Validation::generateCsrfToken();
                                ?>
                                <input type="hidden" name="invoice_id" value="<?= $product['product_id'] ?? ''; ?>">
                                <div><button name="generate_pdf" class="btn btn-success btn-lg rounded w-100">Download invoice</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <canvas id="canvas"></canvas>
    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#input-address').on('input', syncProfileAddress);
            $('#phone-number').on('input', syncProfilePhoneNumber);
        });
    </script>
    <script>
        let W = window.innerWidth;
        let H = window.innerHeight;
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        const maxConfettis = 150;
        const particles = [];
        let opacity = 5.0; // Add opacity to control fade out
        let animationFrameId;

        const possibleColors = [
            "DodgerBlue",
            "OliveDrab",
            "Gold",
            "Pink",
            "SlateBlue",
            "LightBlue",
            "Gold",
            "Violet",
            "PaleGreen",
            "SteelBlue",
            "SandyBrown",
            "Chocolate",
            "Crimson"
        ];

        function randomFromTo(from, to) {
            return Math.floor(Math.random() * (to - from + 1) + from);
        }

        function confettiParticle() {
            this.x = Math.random() * W; // x
            this.y = Math.random() * H - H; // y
            this.r = randomFromTo(11, 33); // radius
            this.d = Math.random() * maxConfettis + 11;
            this.color = possibleColors[Math.floor(Math.random() * possibleColors.length)];
            this.tilt = Math.floor(Math.random() * 33) - 11;
            this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
            this.tiltAngle = 0;

            this.draw = function() {
                context.beginPath();
                context.lineWidth = this.r / 2;
                context.strokeStyle = this.color;
                context.moveTo(this.x + this.tilt + this.r / 3, this.y);
                context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
                context.stroke();
            };
        }

        function Draw() {
            // Magical recursive functional love
            animationFrameId = requestAnimationFrame(Draw);

            context.clearRect(0, 0, W, window.innerHeight);

            // Set global alpha to control opacity
            context.globalAlpha = opacity;

            particles.forEach(particle => particle.draw());

            particles.forEach((particle, i) => {
                particle.tiltAngle += particle.tiltAngleIncremental;
                particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
                particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

                // If a confetti has fluttered out of view,
                // bring it back to above the viewport and let it re-fall.
                if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
                    particle.x = Math.random() * W;
                    particle.y = -30;
                    particle.tilt = Math.floor(Math.random() * 10) - 20;
                }
            });
        }

        window.addEventListener("resize", function() {
            W = window.innerWidth;
            H = window.innerHeight;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }, false);

        // Push new confetti objects to `particles[]`
        for (let i = 0; i < maxConfettis; i++) {
            particles.push(new confettiParticle());
        }

        // Initialize
        canvas.width = W;
        canvas.height = H;
        Draw();

        // Fade out the confetti after 6 seconds
        setTimeout(() => {
            const fadeOut = setInterval(() => {
                opacity -= 0.05;
                if (opacity <= 0) {
                    clearInterval(fadeOut);
                    cancelAnimationFrame(animationFrameId);
                }
            }, 100); // Adjust the interval as needed for smooth fading
        }, 2000); // Start fading after 2 seconds
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