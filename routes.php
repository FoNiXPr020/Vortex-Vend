<?php
use Core\Router;
// Home Page
$router->get('/', 'IndexController@index');
$router->get('/explore', 'IndexController@explore');
$router->get('/logout', 'LogoutController@index');

// Community
$router->get('/contact', 'Community\CommunityController@contact');
$router->post('/contact', 'Community\CommunityController@contactSubmit');
$router->get('/help-center', 'Community\CommunityController@helpCenter');

// Login
$router->get('/login', 'Login\LoginController@index')->middleware('guest');
$router->post('/login', 'Login\LoginController@Login')->middleware('guest');

$router->post('/login/confirmation', 'Login\LoginController@GoogleLogin')->middleware('guest');

// Register
$router->get('/register', 'Register\RegisterController@index')->middleware('guest');
$router->post('/register', 'Register\RegisterController@Register')->middleware('guest');
$router->post('/register/confirmation', 'Register\RegisterController@GoogleRegister')->middleware('guest');

// Dashboard
$router->get('/dashboard', 'Dashboard\DashboardController@index')->middleware('auth');
$router->get('/products', 'Dashboard\DashboardController@products')->middleware('auth');
$router->delete('/delete-account', 'Dashboard\DashboardController@deleteAccount')->middleware('auth');

// Profile
$router->get('/profile', 'Profile\ProfileController@index')->middleware('auth');
$router->post('/profile', 'Profile\ProfileController@update')->middleware('auth');

// Settings
$router->get('/account', 'Settings\SettingsController@index')->middleware('auth');
$router->post('/account', 'Settings\SettingsController@update')->middleware('auth');

// reset password
$router->get('/forgot-password', 'ResetPassword\ResetPasswordController@index')->middleware('guest');
$router->post('/forgot-password', 'ResetPassword\ResetPasswordController@sendReset')->middleware('guest');
$router->get('/reset-password/{token}', 'ResetPassword\ResetPasswordController@verifyReset')->middleware('guest');
$router->post('/reset-password/{token}', 'ResetPassword\ResetPasswordController@confirmReset')->middleware('guest');

// Not done yet - Verify Email
$router->get('/verification', 'VerifyEmail\VerifyEmailController@index')->middleware('check_verified');
$router->post('/verification', 'VerifyEmail\VerifyEmailController@confirm')->middleware('check_verified');
$router->post('/send-verification', 'VerifyEmail\VerifyEmailController@verifyEmail')->middleware('check_verified');

// Products
$router->get('/create-product', 'Products\ProductController@create')->middleware('auth');
$router->post('/create-product', 'Products\ProductController@store')->middleware('auth');
$router->get('/update-product/{id}', 'Products\ProductController@update')->middleware('auth');
$router->put('/update-product/{id}', 'Products\ProductController@updateSubmit')->middleware('auth');
$router->delete('/delete-product/{id}', 'Products\ProductController@delete')->middleware('auth');
$router->get('/products/{id}', 'Products\ProductController@show');

// Only for testing
//$router->get('/notes', 'NotesController@index');
//$router->get('/phpinfo', 'NotesController@phpinfo');
// $router->get('/notes/email', 'NotesController@template');
//$router->get('/notes/password', 'NotesController@template2');
//$router->get('/notes/success', 'NotesController@template3');

// APIs - Users
$router->get('/api/v1/users', 'Api\v1\Users@index');
$router->get('/api/v1/users/{username}', 'Api\v1\Users@getUser');
$router->get('/api/v1/users/{username}/check-username', 'Api\v1\CheckData@checkUsername');
$router->get('/api/v1/users/{email}/check-email', 'Api\v1\CheckData@checkEmail');

// APIs - Followers
$router->get('/api/v1/follow/status/{followerid}', 'Api\v1\Followers@checkFollowStatus');
$router->post('/api/v1/follow/{followerid}', 'Api\v1\Followers@follow');
$router->post('/api/v1/unfollow/{followerid}', 'Api\v1\Followers@unfollow');
$router->get('/api/v1/followers/{id}', 'Api\v1\Followers@getFollowers');
$router->get('/api/v1/following/{id}', 'Api\v1\Followers@getFollowing');

// APIs - Account
$router->post('/api/v1/account/status/customer', 'Api\v1\Account@changeCustomer');
$router->post('/api/v1/account/status/followers', 'Api\v1\Account@changeFollowers');
$router->post('/api/v1/account/status/following', 'Api\v1\Account@changeFollowing');

// APIs - Products
$router->get('/api/v1/explore/products', 'Api\v1\Products@Products');
$router->post('/api/v1/explore/products', 'Api\v1\Products@ProductsLoadMore');
$router->get('/api/v1/explore/products/{username}', 'Api\v1\Products@ProductsofUser');
$router->get('/api/v1/explore/new-arrivals', 'Api\v1\Products@NewArrivals');
$router->post('/api/v1/explore/new-arrivals', 'Api\v1\Products@NewArrivalsLoadMore');
$router->get('/api/v1/explore/top-sellers', 'Api\v1\Products@TopSellers');
$router->post('/api/v1/explore/most-popular', 'Api\v1\Products@MostPopularLoadMore');

// User Dashboard
$router->post('/checkout/{id}', 'IndexController@Checkout');
$router->get('/payment/success', 'IndexController@success');
$router->patch('/download-invoice', 'IndexController@downlaod');
$router->post('/payment/update', 'Profile\ProfileController@updateinsuccess')->middleware('auth');
$router->get('/{username}', 'IndexController@userProfile');
$router->get('/{username}/explore', 'IndexController@exploreProfile');