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
                    <p class="lead text-white-50 m-0">Explore all about products and sales, followers and following</p>
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
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                    Products</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-sales-tab" data-bs-toggle="pill" data-bs-target="#pills-sales" type="button" role="tab" aria-controls="pills-sales" aria-selected="false">
                                    &nbsp;Sales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-followers-tab" data-bs-toggle="pill" data-bs-target="#pills-followers" type="button" role="tab" aria-controls="pills-followers" aria-selected="false">
                                    &nbsp;Followers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-following-tab" data-bs-toggle="pill" data-bs-target="#pills-following" type="button" role="tab" aria-controls="pills-following" aria-selected="false">
                                    &nbsp;Following</button>
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-5">
                                        <button id="load-more-products" class="btn btn-outline-primary btn-lg" data-offset="<?= $offset; ?>">Load more Products</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-sales" role="tabpanel" aria-labelledby="pills-sales-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="new-sales-list">

                                <?php if (isset($sales)) : ?>
                                    <?php foreach ($sales as $sale) : ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?= $sale['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?= $sale['seller_username'] ?? 'Private Account'; ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-<?= $sale['status'] == 'sold' ? 'danger' : 'success'; ?>"><?= $sale['status']; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?= $sale['image']; ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?= $sale['product_name']; ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?= App::truncateString($sale['description'], 40); ?></small></div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?= $sale['price']; ?>$ <span class="text-muted">/ Quantity :</span> <?= $sale['quantity']; ?></div>
                                                </div>
                                                <a href="/products/<?= $sale['product_id']; ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if (empty($sales)) : ?>

                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No sales</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?= $user['username'] ?> has no sales yet</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-5">
                                        <button id="load-more-sales" class="btn btn-outline-primary btn-lg" data-offset="<?= $offset; ?>">Load more Sales</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="most-followers-list">

                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <?php if (isset($followers)) : ?>
                                            <?php foreach ($followers as $follower) : ?>
                                                <div class="col">
                                                    <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                        <div class="card-header border-0 bg-white p-0 mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                        <div class="card-body fw-bold px-0 pb-0">
                                                            <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                            <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                        </div>
                                                        <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["followers_status"] != "public") : ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                    <div class="card-body fw-bold px-0 pb-0">
                                                        <h5 class="card-title mb-1"> Private Followers</h5>
                                                        <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s followers list is private at the moment.</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($followers)) : ?>
                                                <?php foreach ($followers as $follower) : ?>
                                                    <div class="col">
                                                        <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                            <div class="card-header border-0 bg-white p-0 mb-3">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                        <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                            <div class="card-body fw-bold px-0 pb-0">
                                                                <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                                <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                            </div>
                                                            <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["followers_status"] != "public") : ?>
                                        <div class="col-lg-12 mb-5">
                                            <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"> Private Followers</h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s followers list is private at the moment.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <?php if (isset($followers)) : ?>
                                            <?php foreach ($followers as $follower) : ?>
                                                <div class="col">
                                                    <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                        <div class="card-header border-0 bg-white p-0 mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                        <div class="card-body fw-bold px-0 pb-0">
                                                            <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                            <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                        </div>
                                                        <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (empty($followers) && $user["followers_status"] != "private") : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No followers</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?= $user['username']; ?> has no followers yet.</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-following-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="most-following-list">

                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <?php if (isset($following)) : ?>
                                            <?php foreach ($following as $follower) : ?>
                                                <div class="col">
                                                    <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                        <div class="card-header border-0 bg-white p-0 mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                        <div class="card-body fw-bold px-0 pb-0">
                                                            <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                            <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                        </div>
                                                        <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["following_status"] != "public") : ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                    <div class="card-body fw-bold px-0 pb-0">
                                                        <h5 class="card-title mb-1"> Private Following</h5>
                                                        <div class="card-text mb-1"><small class="text-muted"><?= $user['username'] ?>'s following list is private at the moment.</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($following)) : ?>
                                                <?php foreach ($following as $follower) : ?>
                                                    <div class="col">
                                                        <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                            <div class="card-header border-0 bg-white p-0 mb-3">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                        <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                            <div class="card-body fw-bold px-0 pb-0">
                                                                <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                                <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                            </div>
                                                            <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["following_status"] != "public") : ?>
                                        <div class="col-lg-12 mb-5">
                                            <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"> Private Following</h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?= $user['username']  ?>'s following list is private at the moment.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <?php if (isset($following)) : ?>
                                            <?php foreach ($following as $follower) : ?>
                                                <div class="col">
                                                    <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                        <div class="card-header border-0 bg-white p-0 mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <div><img src="<?= $follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="small fw-bold"><?= $follower['username'] ?? 'Private Account'; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <img src="<?= $follower['profile_img']; ?>" class="card-img-top rounded-lg" alt="...">
                                                        <div class="card-body fw-bold px-0 pb-0">
                                                            <h5 class="card-title mb-1"><?= $follower['username']; ?></h5>
                                                            <div class="card-text mb-1"><small class="text-primary">Full Name:</small> <?= $follower['first_name'] . ' ' . $follower['last_name']; ?></div>
                                                        </div>
                                                        <a href="/<?= $follower['username']; ?>" class="stretched-link"></a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (empty($following) && $user["following_status"] != "private") : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No following</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?= $user['username'] ?> is not following anyone.</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

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