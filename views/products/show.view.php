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

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-6 col-12 pe-lg-5">
                    <div class="sidebar-fix">
                        <img src="<?php isset($product['image']) ? print($product['image']) : print "assets/img/products/default-product.jpg"; ?>" alt="#" class="img-fluid w-100 rounded shadow">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="mb-4 mt-2">
                        <h1 class="fw-bold text-dark"><?php isset($product['name']) ? print($product['name']) : print "Vortex Vend"; ?></h1>
                        <div class="mb-5 mt-4">
                            <p class="fs-6"><?php isset($product['description']) ? print($product['description']) : print "Vortex Vend is an platform for buying and selling unique products"; ?></p>
                        </div>
                        <div class="d-flex justify-content-between bg-white rounded shadow-sm p-4 align-items-center">
                            <div>
                                <h6 class="fw-bold mb-2 text-uppercase small">Price in USD</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <h2 class="fw-bold text-primary mt-2"><?php isset($product['price']) ? print($product['price']) : print "0.00"; ?>$</h2>
                                </div>
                            </div>
                            <div>
                                <h6 class="text-muted m-0 d-none d-sm-block mt-2">Quantity: <?php isset($product['quantity']) ? print($product['quantity']) : print "0"; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="pt-1">

                        <div class="pt-3">
                            <h6 class="fw-bold mb-3 text-uppercase fs-6">SELLER</h6>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="overflow-hidden bg-white border-radius-five shadow-sm mb-2">
                                        <div class="p-3 border-bottom">
                                            <p class="m-0 text-uppercase text-muted">CREATED AT <span class="float-end text-muted"><?php isset($product['created_at']) ? print(App::formattedDate($product['created_at'])) : print "N/A"; ?></span></p>
                                            <p class=" m-0 text-uppercase text-muted">UPDATED AT <span class="float-end text-muted"><?php isset($product['updated_at']) ? print(App::formattedDate($product['updated_at'])) : print "N/A"; ?></span></p>
                                        </div>
                                        <div class=" p-3">
                                            <a href="/<?php isset($seller['username']) ? print($seller['username']) : print 'Private Account' ?>" class="text-decoration-none link-dark">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div><img src="<?php isset($seller['profile_img']) ? print($seller['profile_img']) : print "/assets/img/user-default.webp"; ?>" alt="#" class="img-fluid rounded-circle ch-50 border shadow-sm p-1"></div>
                                                    <div>
                                                        <h6 class="fw-bold m-0"><?php isset($seller['first_name']) ? print($seller['first_name'] . ' ' . $seller['last_name']) : print $seller['username']; ?></h6>
                                                    </div>
                                                    <i class="bi bi-chevron-right ms-auto"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <?php if ($product['status'] == "onsale") : ?>
                                        <form action="/checkout/<?php isset($product['id']) ? print($product['id']) : print '' ?>" method="POST">
                                            <?php
                                            Validation::setMethod("POST");
                                            Validation::generateCsrfToken();
                                            ?>
                                            <?php if (isset($token)) : ?>
                                                <input type="hidden" name="_token" value="<?= $token; ?>">
                                            <?php endif; ?>
                                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-lg">Checkout Now</button>
                                        </form>
                                        <?php else : if ($product['status'] == "sold") : ?>
                                            <a href="#" class="btn btn-danger btn-lg px-5 rounded-lg">Sold Out</a>
                                    <?php endif;
                                    endif; ?>
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