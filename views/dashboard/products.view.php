<?php

use Core\Translator;
use Core\Validation;
use Core\App;
use Core\Session;

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
                    <h1 class="text-white display-5 mb-2 fw-bold"><?= $user['username']; ?></h1>
                    <p class="lead text-white-50 m-0">Manage all your of products, update and delete</p>
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
            <div class="row">
                <div class="col-12">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="product-list">

                        <?php if (isset($products)) : ?>
                            <?php foreach ($products as $product) : ?>
                                <div class="col">
                                    <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                        <div class="card-header border-0 bg-white p-0 mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div><img src="<?= $user['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                    <div class="small fw-bold"><?= $user['username'] ?? 'Private Account'; ?></div>
                                                </div>
                                                <div>
                                                    <h3 class="badge bg-<?= $product['status'] == 'sold' ? 'danger' : 'success'; ?>"><?= $product['status']; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="<?= $product['image']; ?>" class="card-img-top rounded-lg" alt="...">
                                        <div class="card-body fw-bold px-0 pb-0">
                                            <h5 class="card-title mb-1"><?= $product['name']; ?></h5>
                                            <div class="card-text mb-1"><small class="text-muted"><?= App::truncateString($product['description'], 40); ?></small></div>
                                            <div class="text-primary"><span class="text-muted">Price :</span> <?= $product['price']; ?>$ <span class="text-muted">/ Quantity :</span> <?= $product['quantity']; ?></div>
                                        </div>
                                        <div class="row mt-3 text-center">
                                            <div class="col">
                                                <a  href="/update-product/<?= $product['id']; ?>" class="btn btn-outline-primary">Update Product</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (empty($products)) : ?>

                            <div class="col-lg-12 mb-5">
                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                    <div class="card-body fw-bold px-0 pb-0">
                                        <h5 class="card-title mb-1"> No Products</h5>
                                        <div class="card-text mb-1"><small class="text-muted"><?= $user['username'] ?> has no products yet</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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