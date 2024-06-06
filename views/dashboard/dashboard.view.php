<?php

use Core\Functions;
use Core\Translator;
use Core\Validation;
use Core\App;
use Core\Session;

?>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
    <link rel="stylesheet" href="<?php assets('css/dash.css'); ?>" type="text/css" />
</head>

<body>

    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section>
        <!-- Cover Profile -->
        <div class="cover-container container-fluid text-center d-lg-block d-none">
            <div class="row">
                <div class="col-12">
                    <img src="<?= $_ENV['APP_DEFAULT_COVER_IMG']; ?>" alt="Cover Profile" id="profileCover" class="cover-image img-fluid rounded-lg">
                </div>
            </div>
        </div>
        <!-- END Cover Profile -->

        <div class="container">
            <div class="row">

                <!-- User Profile -->
                <div class="col-12 col-lg-3">
                    <div class="rounded shadow-osahan bg-white card border-0 author-sidebar">
                        <div class="p-1">
                            <div class="card-body text-center">
                                <div><img src="<?php isset($user['profile_img']) ? print $user['profile_img'] : print $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle border border-5 border-white mb-3 shadow-sm">
                                </div>
                                <h3 class="card-title text-dark fw-bold mb-1"><?php echo $user['first_name'] ? ($user['first_name'] . ' ' . $user['last_name']) : $user['username']; ?></h3>
                                <p class="card-text text-muted">@<?php echo isset($user['username']) ? strtolower($user['username']) : 'Private'; ?></p>

                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] != Session::get('user')['user_id']) : ?>
                                        <div class="card-footer border-0 bg-transparent text-center">
                                            <button id="followBtn" data-follower-id="<?php echo $user['id']; ?>" class="btn btn-primary btn-lg px-5 rounded-lg shadow-sm">Follow</button>
                                        </div>
                                    <?php else : ?>
                                        <div class="card-footer border-0 bg-transparent text-center">
                                            <a href="/profile" id="editProfileBtn" class="btn btn-primary btn-lg px-5 rounded-lg shadow-sm">Edit Profile</a>
                                        </div>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <div class="card-footer border-0 bg-transparent text-center">
                                        <a href="/login" id="loginBtn" class="btn btn-primary btn-lg px-5 rounded-lg shadow-sm">Follow</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center border-top border-bottom">
                            <div class="text-center p-4">
                                <h6 class="fw-bold mb-0"><?= count($products) ?? 0 ?></h6>
                                <div class="text-muted small">Prods</div>
                            </div>

                            <div class="border-start"></div>
                            <div class="text-center p-4">
                                <h6 class="fw-bold mb-0"><?= count($sales) ?? 0 ?></h6>
                                <div class="text-muted small">Sales</div>
                            </div>

                            <div class="border-end"></div>
                            <div class="text-center p-4">
                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <h6 class="fw-bold mb-0"><?= count($followers) ?? 0 ?></h6>
                                        <div class="text-muted small">Followers</div>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["followers_status"] != "public") : ?>
                                            <h6 class="fw-bold mb-0"><i class="bi bi-lock-fill"></i></h6>
                                            <div class="text-muted small">Followers</div>
                                        <?php else : ?>
                                            <h6 class="fw-bold mb-0"><?= count($followers) ?? 0 ?></h6>
                                            <div class="text-muted small">Followers</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["followers_status"] != "public") : ?>
                                        <h6 class="fw-bold mb-0"><i class="bi bi-lock-fill"></i></h6>
                                        <div class="text-muted small">Followers</div>
                                    <?php else : ?>
                                        <h6 class="fw-bold mb-0"><?= count($followers) ?? 0 ?></h6>
                                        <div class="text-muted small">Followers</div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="text-center p-4"><?php isset($user['profile_bio']) ? print($user['profile_bio']) : print(isset($user['first_name']) ? $user['first_name'] . ' ' . $user['last_name'] . ' - has no bio at the moment.' : $user['username'] . ' - has no bio at the moment.'); ?></div>

                        <div class="d-flex gap-2 justify-content-center p-4">
                            <div><a href="#" data-bs-toggle="modal" data-bs-target="#share-btn" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-share-fill"></i></a></div>
                            <div><a href="#" data-bs-toggle="modal" data-bs-target="#report-btn" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-flag-fill"></i></a></div>
                        </div>
                    </div>
                </div>
                <!-- END User Profile -->

                <div class="col-12 col-lg-9 ps-lg-5 py-5">
                    <ul class="nav auther-tabs mb-4 gap-3" id="pills-tab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Products&nbsp;<span class="text-muted"><?= count($products) ?? 0 ?></span></button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-sales-tab" data-bs-toggle="pill" data-bs-target="#pills-sales" type="button" role="tab" aria-controls="pills-sales" aria-selected="false">Sales&nbsp;<span class="text-muted"><?= count($sales) ?? 0 ?></span></button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-customers-tab" data-bs-toggle="pill" data-bs-target="#pills-customers" type="button" role="tab" aria-controls="pills-customers" aria-selected="false">
                                Customers&nbsp;
                                <span class="text-muted">
                                    <?php if (Session::has('user')) : ?>
                                        <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                            <!-- The logged-in user is viewing their own profile -->
                                            <?= count($customers) ?? 0 ?>
                                        <?php else : ?>
                                            <!-- The logged-in user is viewing someone else's profile -->
                                            <?php if ($user["customers_status"] != "public") : ?>
                                                <i class="bi bi-lock-fill"></i>
                                            <?php else : ?>
                                                <?= count($customers) ?? 0 ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- No user is logged in -->
                                        <?php if ($user["customers_status"] != "public") : ?>
                                            <i class="bi bi-lock-fill"></i>
                                        <?php else : ?>
                                            <?= count($customers) ?? 0 ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-followers-tab" data-bs-toggle="pill" data-bs-target="#pills-followers" type="button" role="tab" aria-controls="pills-followers" aria-selected="false">
                                Followers&nbsp;
                                <span class="text-muted">
                                    <?php if (Session::has('user')) : ?>
                                        <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                            <!-- The logged-in user is viewing their own profile -->
                                            <?= count($followers) ?? 0 ?>
                                        <?php else : ?>
                                            <!-- The logged-in user is viewing someone else's profile -->
                                            <?php if ($user["followers_status"] != "public") : ?>
                                                <i class="bi bi-lock-fill"></i>
                                            <?php else : ?>
                                                <?= count($followers) ?? 0 ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- No user is logged in -->
                                        <?php if ($user["followers_status"] != "public") : ?>
                                            <i class="bi bi-lock-fill"></i>
                                        <?php else : ?>
                                            <?= count($followers) ?? 0 ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </button>
                        </li>


                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-following-tab" data-bs-toggle="pill" data-bs-target="#pills-following" type="button" role="tab" aria-controls="pills-following" aria-selected="false">
                                Following&nbsp;
                                <span class="text-muted">
                                    <?php if (Session::has('user')) : ?>
                                        <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                            <!-- The logged-in user is viewing their own profile -->
                                            <?= count($following) ?? 0 ?>
                                        <?php else : ?>
                                            <!-- The logged-in user is viewing someone else's profile -->
                                            <?php if ($user["following_status"] != "public") : ?>
                                                <i class="bi bi-lock-fill"></i>
                                            <?php else : ?>
                                                <?= count($following) ?? 0 ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- No user is logged in -->
                                        <?php if ($user["following_status"] != "public") : ?>
                                            <i class="bi bi-lock-fill"></i>
                                        <?php else : ?>
                                            <?= count($following) ?? 0 ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </button>
                        </li>
                        
                        <?php if (Session::has('user')) : ?>
                        <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-purchases-tab" data-bs-toggle="pill" data-bs-target="#pills-purchases" type="button" role="tab" aria-controls="pills-purchases" aria-selected="false">Purchases&nbsp;<span class="text-muted"> <?= count($purchases) ?? 0 ?> </span></button>
                        </li>
                        <?php endif; endif; ?>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                                <!-- Product Card -->
                                <?php if (isset($products)) : $count = 0;
                                    foreach ($products as $product) : if ($count++ >= 6) break; ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?php print($user['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?php print($user['username']); ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-<?php print($product['status'] == 'sold' ? 'danger' : 'success'); ?>"><?php print($product['status']); ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?php print($product['image']); ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?php print($product['name']); ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print(App::truncateString($product['description'], 40)); ?></small>
                                                    </div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?php print($product['price']); ?>$ <span class="text-muted">/ Quantity :</span> <?php print($product['quantity']); ?></div>
                                                </div>
                                                <a href="/products/<?php print($product['id']); ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                <?php endforeach;
                                endif; ?>

                                <?php if ($products == null) : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No Products</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> are not a seller at the moment.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($products != null) : ?>
                                <div class="text-center mt-5"><a href="/<?= $user['username']; ?>/explore" class="btn btn-outline-primary btn-lg px-5 rounded-lg shadow-sm">Explore Products</a></div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-sales" role="tabpanel" aria-labelledby="pills-sales-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                                <!-- Product Card -->
                                <?php if (isset($sales)) : $count = 0;
                                    foreach ($sales as $sale) : if ($count++ >= 6) break; ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?php print($user['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?php print($user['username']); ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-danger">Sold</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?php print($sale['image']); ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?php print($sale['name']); ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print(App::truncateString($sale['description'], 40)); ?></small>
                                                    </div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?php print($sale['price']); ?>$ <span class="text-muted">/ Quantity :</span> <?php print($sale['quantity']); ?></div>
                                                </div>
                                                <a href="/products/<?php print($sale['id']); ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                <?php endforeach;
                                endif; ?>

                                <?php if ($sales == null) : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No sales</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> are not a seller at the moment.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($sales != null) : ?>
                                <div class="text-center mt-5"><a href="/<?= $user['username']; ?>/explore" class="btn btn-outline-primary btn-lg px-5 rounded-lg shadow-sm">See sales</a></div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-customers" role="tabpanel" aria-labelledby="pills-customers-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <?php if (isset($customers)) : $count = 0;
                                            foreach ($customers as $customer) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($customer['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($customer['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($customer['username']) ? print $customer['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["customers_status"] != "public") : ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                    <div class="card-body fw-bold px-0 pb-0">
                                                        <h5 class="card-title mb-1"> Private Customers</h5>
                                                        <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s customers list is private at the moment.</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($customers)) : $count = 0;
                                                foreach ($customers as $customer) : if ($count++ >= 12) break; ?>
                                                    <div class="col">
                                                        <a href="/<?php print($customer['username']); ?>" class="text-decoration-none link-dark">
                                                            <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div><img src="<?php print($customer['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="fw-bold"><?php isset($customer['username']) ? print $customer['username'] : print 'Private Account' ?></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                            <?php endforeach;
                                            endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["customers_status"] != "public") : ?>
                                        <div class="col-lg-12 mb-5">
                                            <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"> Private Customers</h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s customers list is private at the moment.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <?php if (isset($customers)) : $count = 0;
                                            foreach ($customers as $customer) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($customer['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($customer['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($customer['username']) ? print $customer['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($customers == null && $user["customers_status"] != "private") : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No Customers</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> is not a seller at the moment.</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($customers != null && $user["customers_status"] != "private") : ?>
                                <div class="text-center mt-5"><a href="/<?= $user['username']; ?>/explore" class="btn btn-outline-primary btn-lg px-5 rounded-lg shadow-sm">See customers</a></div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <?php if (isset($followers)) : $count = 0;
                                            foreach ($followers as $follower) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["followers_status"] != "public") : ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                    <div class="card-body fw-bold px-0 pb-0">
                                                        <h5 class="card-title mb-1"> Private Followers </h5>
                                                        <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s followers list is private at the moment.</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($followers)) : $count = 0;
                                                foreach ($followers as $follower) : if ($count++ >= 12) break; ?>
                                                    <div class="col">
                                                        <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                            <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                            <?php endforeach;
                                            endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["followers_status"] != "public") : ?>
                                        <div class="col-lg-12 mb-5">
                                            <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"> Private Followers </h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s followers list is private at the moment.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <?php if (isset($followers)) : $count = 0;
                                            foreach ($followers as $follower) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($followers == null && $user["followers_status"] != "private") : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No Followers</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> has no followers yet.</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($followers != null && $user["followers_status"] != "private") : ?>
                                <div class="text-center mt-5"><a href="/<?= $user['username']; ?>/explore" class="btn btn-outline-primary btn-lg px-5 rounded-lg shadow-sm">See followers</a></div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-following-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                                <?php if (Session::has('user')) : ?>
                                    <?php if ($user['id'] == Session::get('user')['user_id']) : ?>
                                        <!-- The logged-in user is viewing their own profile -->
                                        <?php if (isset($following)) : $count = 0;
                                            foreach ($following as $follower) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php else : ?>
                                        <!-- The logged-in user is viewing someone else's profile -->
                                        <?php if ($user["following_status"] != "public") : ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                    <div class="card-body fw-bold px-0 pb-0">
                                                        <h5 class="card-title mb-1"> Private Following</h5>
                                                        <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s following list is private at the moment.</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($following)) : $count = 0;
                                                foreach ($following as $follower) : if ($count++ >= 12) break; ?>
                                                    <div class="col">
                                                        <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                            <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                    <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                            <?php endforeach;
                                            endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- No user is logged in -->
                                    <?php if ($user["following_status"] != "public") : ?>
                                        <div class="col-lg-12 mb-5">
                                            <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"> Private Following</h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?>'s following list is private at the moment.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <?php if (isset($following)) : $count = 0;
                                            foreach ($following as $follower) : if ($count++ >= 12) break; ?>
                                                <div class="col">
                                                    <a href="/<?php print($follower['username']); ?>" class="text-decoration-none link-dark">
                                                        <div class="bg-white rounded shadow-sm p-3 followers-items">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div><img src="<?php print($follower['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                                <div class="fw-bold"><?php isset($follower['username']) ? print $follower['username'] : print 'Private Account' ?></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($following == null && $user["following_status"] != "private") : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No Following</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> is not following anyone yet.</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($following != null && $user["following_status"] != "private") : ?>
                                <div class="text-center mt-5"><a href="/<?= $user['username']; ?>/explore" class="btn btn-outline-primary btn-lg px-5 rounded-lg shadow-sm">See following</a></div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-purchases" role="tabpanel" aria-labelledby="pills-purchases-tab">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                                <!-- Product Card -->
                                <?php if (isset($purchases)) : $count = 0;
                                    foreach ($purchases as $purchase) : if ($count++ >= 6) break; ?>
                                        <div class="col">
                                            <div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
                                                <div class="card-header border-0 bg-white p-0 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div><img src="<?php print($purchase['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
                                                            <div class="small fw-bold"><?php print($purchase['username']); ?></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="badge bg-danger">Sold</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?php print($purchase['image']); ?>" class="card-img-top rounded-lg" alt="...">
                                                <div class="card-body fw-bold px-0 pb-0">
                                                    <h5 class="card-title mb-1"><?php print($purchase['name']); ?></h5>
                                                    <div class="card-text mb-1"><small class="text-muted"><?php print(App::truncateString($purchase['description'], 40)); ?></small>
                                                    </div>
                                                    <div class="text-primary"><span class="text-muted">Price :</span> <?php print($purchase['price']); ?>$ <span class="text-muted">/ Quantity :</span> <?php print($purchase['quantity']); ?></div>
                                                </div>
                                                <a href="/products/<?php print($purchase['id']); ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                <?php endforeach;
                                endif; ?>

                                <?php if ($purchases == null) : ?>
                                    <div class="col-lg-12 mb-5">
                                        <div class="osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0 text-center">
                                            <div class="card-body fw-bold px-0 pb-0">
                                                <h5 class="card-title mb-1"> No Purchases made</h5>
                                                <div class="card-text mb-1"><small class="text-muted"><?php print($user['username']); ?> you have not made any purchases yet.</small>
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
        </div>
    </section>

    <div class="modal fade" id="share-btn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 rounded">
                <div class="modal-header">
                    <h5 class="modal-title">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="input-group rounded bg-white my-3 shadow-sm overflow-hidden p-2">
                    <input type="text" id="copyInput" class="form-control bg-white border-0" value="<?php echo App::getURI() . '/' . $user['username']; ?>" disabled>
                    <button type="button" class="input-group-text border-0 bg-white text-primary copy-link" fulllink="<?php echo App::getURI() . '/' . $user['username']; ?>">
                        <i class="bi bi-clipboard-fill"></i>
                    </button>
                </div>
                <div class="modal-body text-center d-flex align-items-center justify-content-center gap-2">
                    <a href="www.facebook.com" target="_blank" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-facebook"></i></a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('Check out this link: ' . App::getURI() . '/' . $user['username'] . ''); ?>" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-whatsapp"></i></a>
                    <a href="https://www.instagram.com" target="_blank" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com" class="btn-icon btn-light btn shadow-sm rounded-circle border"><i class="bi bi-linkedin"></i></a>
                </div>

            </div>
        </div>
    </div>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
    <script src="<?php assets('js/dashboard.js'); ?>"></script>
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