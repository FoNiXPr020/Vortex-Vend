<?php

use Core\Translator;
use Core\Validation;
use Core\App;

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
                    <h1 class="text-white display-5 mb-2 fw-bold">Explore</h1>
                    <p class="lead text-white-50 m-0">Discover our vast selection of products</p>
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
            <div class="overflow-hidden mb-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-6">
                        <ul class="nav explore-tabs mb-0 justify-content-center gap-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><i class="bi bi-cart4"></i></span>
                                Products</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-arrivals-tab" data-bs-toggle="pill" data-bs-target="#pills-arrivals" type="button" role="tab" aria-controls="pills-arrivals" aria-selected="false"><span><i class="bi bi-lightning-fill"></i></span>
                                    &nbsp;New Arrivals</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-papular-tab" data-bs-toggle="pill" data-bs-target="#pills-papular" type="button" role="tab" aria-controls="pills-papular" aria-selected="false"><span><i class="bi bi-bag-heart-fill"></i></span>
                                    &nbsp;Most Popular</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="product-list">

                                <?php if (isset($products)) : ?>
                                    <?php foreach ($products as $product) : ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?= $product['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?= $product['seller_username'] ?? 'Private Account'; ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-<?= $product['status'] == 'sold' ? 'danger' : 'success'; ?>"><?= $product['status']; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?= $product['image']; ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?= $product['product_name']; ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?= App::truncateString($product['description'], 40); ?></small></div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?= $product['price']; ?>$ <span class="text-muted">/ Quantity :</span> <?= $product['quantity']; ?></div>
                                                </div>
                                                <a href="/products/<?= $product['product_id']; ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-5">
                                        <button id="load-more-products" class="btn btn-outline-primary btn-lg" data-offset="<?= $offset; ?>">Load more Products</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-arrivals" role="tabpanel" aria-labelledby="pills-arrivals-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="new-arrival-list">

                                <?php if (isset($Arrivals)) : ?>
                                    <?php foreach ($Arrivals as $Arrival) : ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?= $Arrival['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?= $Arrival['seller_username'] ?? 'Private Account'; ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-<?= $Arrival['status'] == 'sold' ? 'danger' : 'success'; ?>"><?= $Arrival['status']; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?= $Arrival['image']; ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?= $Arrival['product_name']; ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?= App::truncateString($Arrival['description'], 40); ?></small></div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?= $Arrival['price']; ?>$ <span class="text-muted">/ Quantity :</span> <?= $Arrival['quantity']; ?></div>
                                                </div>
                                                <a href="/products/<?= $Arrival['product_id']; ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-5">
                                        <button id="load-more-arrivals" class="btn btn-outline-primary btn-lg" data-offset="<?= $offset; ?>">Load more Arrivals</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-papular" role="tabpanel" aria-labelledby="pills-papular-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="most-popular-list">

                                <?php if (isset($populars)) : ?>
                                    <?php foreach ($populars as $popular) : ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?= $popular['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?= $popular['seller_username'] ?? 'Private Account'; ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-<?= $popular['status'] == 'sold' ? 'danger' : 'success'; ?>"><?= $popular['status']; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?= $popular['image']; ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?= $popular['product_name']; ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?= App::truncateString($popular['description'], 40); ?></small></div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?= $popular['price']; ?>$ <span class="text-muted">/ Quantity :</span> <?= $popular['quantity']; ?></div>
                                                </div>
                                                <a href="/products/<?= $popular['product_id']; ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-5">
                                        <button id="load-more-populars" class="btn btn-outline-primary btn-lg" data-offset="<?= $offset; ?>">Load more Arrivals</button>
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
    <script src="<?php assets('js/explore.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#load-more-products').click(LoadProducts);
            $('#load-more-arrivals').click(LoadArrivals);
            $('#load-more-populars').click(LoadPopulars);
        });
    </script>
</body>

</html>