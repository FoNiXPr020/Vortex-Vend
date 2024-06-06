<?php

use Core\Translator;
use Core\App;
use Core\Validation;

?>
<?php require_once BASE_VIEW_MAIN . 'navbar.php'; ?>

<section class="background-image py-5 bg-white">
	<div class="container py-4 text-center mt-5">
		<div class="row justify-content-center">
			<div class="col-lg-7 col-12 text-center">
				<div class="mb-4">

					<h1 class="display-5 fw-bold text-dark">VortexVend</h1>
					<div class="display-5 fw-bold text-dark mb-3">Buy, Sell, Discover Exclusive Products</div>
					<div class="fs-5 text-dark-50">Join us in revolutionizing the world of products</div>
				</div>
				<div class="d-flex justify-content-center">
					<div class="col-auto">
						<a href="#Discover-Products" class="btn btn-success btn-lg rounded me-3">Discover</a>
					</div>
					<div class="col-auto">
						<a href="/register" class="btn btn-primary btn-lg rounded">Be a Seller</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row g-4 mt-5">
			<div class="col-lg-4 col-4">
				<div class="rounded shadow-sm p-4 bg-dark d-flex align-items-center gap-3 steps-item">
					<span class="bg-success rounded-circle steps-item-icon"><i class="bi bi-search text-white"></i></span>
					<div>
						<div class="fw-bold fs-6 mb-1 d-none d-md-block text-white">Discover Unique Products</div>
						<div class="fw-bold fs-6 mb-1 d-lg-none text-dark">Discover Unique Products</div>
						<p class="text-muted m-0 d-none d-md-block">Explore our vast selection of unique products</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="rounded shadow-sm p-4 bg-dark d-flex align-items-center gap-3 steps-item">
					<span class="bg-success rounded-circle steps-item-icon"><i class="bi bi-cart-check text-white"></i></span>
					<div>
						<div class="fw-bold fs-6 mb-1 d-none d-md-block text-white">Place your Order</div>
						<div class="fw-bold fs-6 mb-1 d-lg-none text-dark">Place your Order</div>
						<div class="text-muted m-0 d-none d-md-block">Place your order and get it delivered to your doorstep</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="rounded shadow-sm p-4 bg-dark d-flex align-items-center gap-3 steps-item">
					<span class="bg-success rounded-circle steps-item-icon"><i class="bi bi-house-door text-white"></i></span>
					<div>
						<div class="fw-bold fs-6 mb-1 d-none d-md-block text-white">Get it at your doorstep</div>
						<div class="fw-bold fs-6 mb-1 d-lg-none text-dark">Get it at your doorstep</div>
						<div class="text-muted m-0 d-none d-md-block">Your product will be delivered to your doorstep</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- New Arrivals -->
<section id="Live-Auctions" class="bg-dark py-3">
	<div class="container my-4">
		<div class="mt-2 mb-2">
			<div class="d-flex align-items-center justify-content-between mb-4 pb-1">
				<div class="h4 m-0 fw-bold text-white ms-4">New Arrivals ⚡️</div>
				<div><a href="/explore" class="btn btn-outline-primary btn-sm px-3">See all</a></div>
			</div>
			<div class="live-auctions">
				<?php if (isset($newArrivals)) : $count = 0;
					foreach ($newArrivals as $newArrival) : if ($count++ >= 8) break; ?>
						<div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
							<div class="card-header border-0 bg-white p-0 mb-3">
								<div class="d-flex justify-content-between">
									<div class="d-flex gap-2 align-items-center">
										<div><img src="<?php print($newArrival['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']); ?>" alt="#" class="img-fluid rounded-circle"></div>
										<div class="small fw-bold"><?php print($newArrival['seller_username']); ?></div>
									</div>
									<div>
										<h3 class="badge bg-<?php print($newArrival['status'] == 'sold' ? 'danger' : 'success'); ?>"><?php print($newArrival['status']); ?></h3>
									</div>
								</div>
							</div>

							<img src="<?php print($newArrival['image']); ?>" class="card-img-top rounded-lg" alt="...">
							<div class="card-body fw-bold px-0 pb-0">
								<h5 class="card-title mb-1"><?php print($newArrival['product_name']); ?></h5>
								<div class="card-text mb-1"><small class="text-muted"><?php print(App::truncateString($newArrival['description'], 40)); ?></small>
								</div>
								<div class="text-primary"><span class="text-muted">Price :</span> <?php print($newArrival['price']); ?>$ <span class="text-muted">/ Quantity :</span> <?php print($newArrival['quantity']); ?></div>
							</div>
							<a href="/products/<?php print($newArrival['product_id']); ?>" class="stretched-link"></a>
						</div>
				<?php endforeach;
				endif; ?>
				<?php if (empty($newArrivals)) : ?>
					<div class="col-lg-12 mb-5 text-center">
						<div class="osahan-item-list p-3 h-100 shadow-osahan border-0 text-center bg-light rounded text-dark">
							<div class="card-body fw-bold px-0 pb-0">
								<h5 class="card-title mb-1">Exclusive products are coming soons</h5>
								<div class="card-text mb-1"><small class="text-muted">There are no products at the moment.</small>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Top Sellers -->
<section id="Top-Artists" class="bg-dark py-3">
	<div class="container my-4">
		<div class="mt-2 mb-2">
			<div class="d-flex align-items-center justify-content-between mb-4">
				<div class="h4 m-0 fw-bold text-white">Top Sellers 👑</div>
				<div><a href="/explore" class="btn btn-outline-primary btn-sm px-3">See all</a></div>
			</div>
			<div class="row g-3">
				<?php if (isset($topSellers)) : $count = 0;
					foreach ($topSellers as $topSeller) : if ($count++ >= 6) break; ?>
						<div class="col-6 col-md-4 col-lg-2">
							<div class="top-artistss">
								<div class="p-2 rounded shadow-osahan bg-white card border-0">
									<img src="<?php assets('img/Default/tim-chow.jpg'); ?>" class="card-img-top rounded-lg" alt="...">
									<div class="m-auto"><img src="<?= $topSeller['profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle profile shadow-sm"></div>

									<div class="bluetick"><i class="bi bi-check-circle-fill text-primary border border-white rounded-circle bg-white"></i></div>
									<div class="card-body text-center py-1">
										<h6 class="card-title mb-1 text-dark fw-bold mt-2"><?= $topSeller['username'] ?? 'Private Account'; ?></h6>
										<p class="card-text text-muted small mb-2">@<?= strtolower($topSeller['username']); ?></p>
									</div>
								</div>
								<a href="/<?= $topSeller['username'] ?? ''; ?>" class="stretched-link"></a>
							</div>
						</div>
				<?php endforeach;
				endif; ?>
				<?php if (empty($topSellers)) : ?>
					<div class="col-lg-12 mb-5 text-center">
						<div class="osahan-item-list p-3 h-100 shadow-osahan border-0 text-center bg-light rounded text-dark">
							<div class="card-body fw-bold px-0 pb-0">
								<h5 class="card-title mb-1">Exclusive products are coming soons</h5>
								<div class="card-text mb-1"><small class="text-muted">There are no products at the moment.</small>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Discover Products -->
<section id="Discover-Products" class="bg-dark py-3">
	<div class="container my-4">
		<div class="mt-2 mb-2">
			<div class="d-flex align-items-center justify-content-between mb-4">
				<div class="h4 m-0 fw-bold text-white">Discover Products 🛒</div>
				<div><a href="/explore" class="btn btn-outline-primary btn-sm px-3">See all</a></div>
			</div>
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

				<?php if (isset($products)) : $count = 0;
					foreach ($products as $product) : if ($count++ >= 12) break; ?>
						<div class="col">
							<div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">
								<div class="card-header border-0 bg-white p-0 mb-3">
									<div class="d-flex justify-content-between">
										<div class="d-flex gap-2 align-items-center">
											<div><img src="<?= $product['seller_profile_img'] ?? $_ENV['APP_DEFAULT_PROFILE_IMG']; ?>" alt="#" class="img-fluid rounded-circle"></div>
											<div class="small fw-bold"><?= $product['seller_username'] ?? 'Private Account'; ?></div>
										</div>
										<div>
											<h3 class="badge bg-<?php print($product['status'] == 'sold' ? 'danger' : 'success'); ?>"><?php print($product['status']); ?></h3>
										</div>
									</div>
								</div>
								<img src="<?php print($product['image']); ?>" class="card-img-top rounded-lg" alt="...">
								<div class="card-body fw-bold px-0 pb-0">
									<h5 class="card-title mb-1"><?php print($product['product_name']); ?></h5>
									<div class="card-text mb-1"><small class="text-muted"><?php print(App::truncateString($product['description'], 40)); ?></small>
									</div>
									<div class="text-primary"><span class="text-muted">Price :</span> <?php print($product['price']); ?>$ <span class="text-muted">/ Quantity :</span> <?php print($product['quantity']); ?></div>
								</div>
								<a href="/products/<?php print($product['product_id']); ?>" class="stretched-link"></a>
							</div>
						</div>
				<?php endforeach;
				endif; ?>

				<?php if (empty($products)) : ?>
					<div class="col-lg-12 mb-5 text-center">
						<div class="osahan-item-list p-3 h-100 shadow-osahan border-0 text-center bg-light rounded text-dark">
							<div class="card-body fw-bold px-0 pb-0">
								<h5 class="card-title mb-1">Exclusive products are coming soons</h5>
								<div class="card-text mb-1"><small class="text-muted">There are no products at the moment.</small>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<div class="d-flex justify-content-center mt-5">
				<a href="/explore" class="btn btn-outline-primary">Explore more products</a>
			</div>
		</div>
	</div>
</section>

<section class="bg-primary py-4">
	<div class="container py-4">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-7 col-md-8 col-12">
				<div class="text-center py-4">
					<small class="text-white-50">ACTIVITY</small>
					<h1 class="fw-bold text-white py-3">We make sure that everyone is able to use a Vortex Vend</h1>
					<a href="/about" class="btn btn-light btn-lg"> More Info </a>
				</div>
			</div>
		</div>
	</div>
</section>