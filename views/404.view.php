<?php

use Core\Translator;
?>
<!doctype html>
<html lang="en">

<head>
    <?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
</head>

<body>
    <?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

    <section class="py-4">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-8 mx-auto">
                    <div class="text-center">
                        <img src="<?php assets('img/Default/404.svg'); ?>" class="img-fluid w-50" alt="#">
                        <div class="fw-bold text-dark display-6 my-3 text-uppercase">Page not found!</div>
                        <div class="text-muted fs-6 mb-5">The page you are looking for does not exist or has been moved!</div>
                        <a href="/" class="btn btn-primary btn-lg">Back to Platform</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once BASE_VIEW_MAIN . 'footer.php'; ?>
    <?php require_once BASE_VIEW_MAIN . 'scripts.php'; ?>
</body>

</html>