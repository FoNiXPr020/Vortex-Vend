<?php

use Core\Translator;
use Core\Session;
use Core\Validation;

?>
<footer class="footer bg-white py-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12 col-lg-2 col-12">
                <img src="<?php assets('img/Logos/LogoDark-NB-removebg-preview.png'); ?>" alt="Vortex Vend" class="img-fluid">
                <div class="text-muted mt-4">
                    <p class="mb-4">Vortex Vend is an platform for buying and selling unique products</p>
                    <div class="d-flex gap-3 fs-6">
                        <a href="#" class="text-decoration-none link-dark"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-decoration-none link-dark"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-decoration-none link-dark"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 col-4">
                <h6 class="fw-bold text-body mb-3">Home</h6>
                <ul class="nav flex-column">
                    <li><a class="nav-link" href="/dashboqrd">Dashboard</a></li>
                    <li><a class="nav-link" href="/about">About Us</a></li>
                    <li><a class="nav-link" href="/fqa">FQA</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-2 col-4">
                <h6 class="fw-bold text-body mb-3">COMMUNITY</h6>
                <ul class="nav flex-column">
                    <li><a class="nav-link" href="/blog">Blog</a></li>
                    <li><a class="nav-link" href="/help-center">Help Center</a></li>
                    <li><a class="nav-link" href="/contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-2 col-4">
                <h6 class="fw-bold text-body mb-3">EXPLORE</h6>
                <ul class="nav flex-column">
                    <li><a class="nav-link" href="/new-arrivals">New Arrivals</a></li>
                    <li><a class="nav-link" href="/popular">Popular Products</a></li>
                    <li><a class="nav-link" href="/top-sellers">Top Sellers</a></li>
                    <li><a class="nav-link" href="/discover">Discover Products</a></li>
                </ul>
            </div>
            <div class="col-md-12 col-lg-4 col-12">
                <form action="/subscribe" method="POST">
                    <h6 class="fw-bold text-body mb-2">SUBSCRIBE</h6>
                    <div class="mb-4 text-muted">Subscribe for the latest news, offers & promotions</div>
                    <div class="input-group">
                        <input type="text" id="subscribe_email" name="subscribe_email" class="form-control" placeholder="Enter Your Email">
                        <button class="btn btn-primary" type="button"><i class="bi bi-envelope me-2"></i> Subscribe</button>
                    </div>
                    <div class="small mt-3 text-primary">No worries we don't spam! Unsubscribe at any time by <br>clicking on the link in the email.</div>
                </form>
            </div>
        </div>
    </div>
</footer>
<div class="footer-mid">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-auto">
                <div class="">
                    <a href="index.html" class="text-decoration-none link-dark fw-bold pe-2">Home</a>
                    <a href="explore.html" class="text-decoration-none link-dark fw-bold px-2">Explore</a>
                    <a href="terms.html" class="text-decoration-none link-dark fw-bold px-2">Terms</a>
                    <a href="privacy-policy.html" class="text-decoration-none link-dark fw-bold px-2">Privacy policy</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-end bg-white py-4">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <span class="small">© <?php echo date('Y');?> <a href="https://vortex-vend.com" class="text-decoration-none text-primary">Vortex Vend</a> , All rights reserved.</span>
            </div>
        </div>
    </div>
</div>