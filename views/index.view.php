<?php
use Core\Functions;
use Core\Session;
use Core\Translator;
use Core\Validation;
?>

<!doctype html>
<html lang="en">
<head>
<?php require_once BASE_VIEW_MAIN . 'header.php'; ?>
</head>

<body>
	<?php require_once BASE_VIEW_MAIN . 'main.php'; ?>
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