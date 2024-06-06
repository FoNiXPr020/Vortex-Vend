<?php

use Core\Translator;
use Core\App;
use Core\Functions;
use Core\Session;

$app = new App();
$selectedLanguage = Translator::getSelectedLanguage();

if (Session::has('user'))
	$navUser = Functions::sanitizeArray(Session::get('user'));
else
	$navUser = null;

?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-0 osahan-nav">
	<div class="container mb-2">
		<a class="navbar-brand" href="/">
			<img src="<?php assets('img/Logos/LogoDark-NB-removebg-preview.png'); ?>" alt="#" class="img-fluid">
		</a>

		<button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup16" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNavAltMarkup16">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="/">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/help-center">About US</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Community
					</a>
					<ul class="dropdown-menu border-0 shadow-sm">
						<li><a class="dropdown-item" href="/help-center">Help Center</a></li>
						<li><a class="dropdown-item" href="/contact">Contact</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Explore
					</a>
					<ul class="dropdown-menu border-0 shadow-sm">
						<li><a class="dropdown-item" href="/explore">New Arrivals</a></li>
						<li><a class="dropdown-item" href="/explore">Popular Products</a></li>
						<li><a class="dropdown-item" href="/explore">Top Sellers</a></li>
						<li><a class="dropdown-item" href="/explore">Discover Products</a></li>
					</ul>
				</li>

				<li class="nav-item d-lg-none dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $app->getEchoLANG($selectedLanguage); ?>
					</a>
					<ul class="dropdown-menu border-0 shadow-sm">
						<?php
						$languages = Translator::AvailableLanguages();

						// Loop through the available languages to generate dropdown items
						foreach ($languages as $code => $details) {
							// Skip the selected language
							if ($code != $selectedLanguage) {
								$languageName = $details[0];
								$iconClass = $details[1];
								// Generate the URL with the language parameter
								$url = strtok($_SERVER["REQUEST_URI"], '?') . '?lang=' . $code;
						?>
								<li><a class="dropdown-item" href="<?php echo $url; ?>" lang="<?php echo $code; ?>"><?php echo $languageName; ?> <span class="<?php echo $iconClass; ?>" style="border-radius: 3px"></span></a></li>
						<?php
							}
						}
						?>
					</ul>
				</li>

			</ul>
			<div class="navbar-nav ms-auto gap-3">

				<?php if (Session::has('user')) :
					$currentURL = $app->getCurrentURL();
					if (strpos($currentURL, '/create-product') === false) : ?>
						<a class="btn btn-dark btn-sm" href="/create-product">Create</a>
				<?php
					endif;
				endif; ?>

				<!-- Language Dropdown -->
				<div class="nav-item dropdown d-lg-block d-none">
					<a class="nav-link position-relative p-0 messages-btn text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<span class="img-fluid border-radius-five top-icon"><i class="bi bi-globe2 fs-6"></i></span>
					</a>
					<div class="dropdown-menu border-0 shadow-sm dropdown-menu-start dropdown-menu-lg-end mt-3">
						<?php
						$languages = Translator::AvailableLanguages();

						// Loop through the available languages to generate dropdown items
						foreach ($languages as $code => $details) {
							// Skip the selected language
							if ($code != $selectedLanguage) {
								$languageName = $details[0];
								$iconClass = $details[1];
								// Generate the URL with the language parameter
								$url = strtok($_SERVER["REQUEST_URI"], '?') . '?lang=' . $code;
						?>
								<a class="dropdown-item" href="<?php echo $url; ?>" lang="<?php echo $code; ?>"><?php echo $languageName; ?> <span class="<?php echo $iconClass; ?>" style="border-radius: 3px"></span></a>
						<?php
							}
						}
						?>
					</div>
				</div>

				<!-- Login AND Register Button -->
				<?php
				$buttonInfo = $app->getButtonInfo();
				if (!Session::has('user')) :
				?>
					<a href="<?= $buttonInfo['href'] ?>" class="btn btn-dark btn-sm"><?= $buttonInfo['text']; ?></a>
				<?php endif; ?>

				<!-- For a browser -->
				<?php if (Session::has('user')) : ?>

					<div class="nav-item dropdown d-lg-block d-none">
						<a class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?= $navUser['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid border-radius-five top-icon">
						</a>
						<div class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-3">
							<div>
								<a class="dropdown-item" href="/<?php echo $navUser['username']; ?>">
									<div class="fw-bold mb-1"><?php echo isset($navUser['first_name']) ? $navUser['first_name'] . ' ' . $navUser['last_name'] : $navUser['username']; ?></div>
									<div class="text-muted small">@<?php echo isset($navUser['username']) ? strtolower($navUser['username']) : strtolower($navUser['username']); ?></div>
								</a>
							</div>
							<div><a class="dropdown-item text-primary" href="/products"><i class="bi bi-list-ul me-2"></i> My Products</a></div>
							<div><a class="dropdown-item" href="/account"><i class="bi bi-person-plus me-2"></i> Account</a></div>
							<div><a class="dropdown-item" href="/profile"><i class="bi bi-pen me-2"></i> Edit Profile</a></div>
							<div><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Log out</a></div>
						</div>
					</div>
				<?php endif; ?>

				<!-- For mobile -->
				<?php if (Session::has('user')) : ?>
					<div class="nav-item dropdown d-lg-none">
						<a class="nav-link btn btn-dark btn-sm dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo $navUser['username'] ?>
						</a>
						<div class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-3">
							<div>
								<a class="dropdown-item" href="/<?php echo $navUser['username']; ?>">
									<div class="fw-bold mb-1"><?php echo isset($navUser['first_name']) ? $navUser['first_name'] . ' ' . $navUser['last_name'] : $navUser['username']; ?></div>
									<div class="text-muted small">@<?php echo isset($navUser['username']) ? strtolower($navUser['username']) : strtolower($navUser['username']); ?></div>
								</a>
							</div>
							<div><a class="dropdown-item text-primary" href="/products"><i class="bi bi-list-ul me-2"></i> My Products</a></div>
							<div><a class="dropdown-item" href="/account"><i class="bi bi-pen me-2"></i> Account</a></div>
							<div><a class="dropdown-item" href="/profile"><i class="bi bi-person-plus me-2"></i> Edit Profile</a></div>
							<div><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></div>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</nav>