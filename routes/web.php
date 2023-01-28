<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomPaginateController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SslCommerzPaymentController;

//frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::get('/customer/register/login', [FrontendController::class, 'customer_register_login'])->name('customer.reglogin');
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
Route::get('/categories/product/{category_id}', [FrontendController::class, 'categories_product'])->name('categories.product');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//users
Route::get('/users', [HomeController::class, 'users'])->name('user');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::post('/profile/update', [HomeController::class, 'profile_update'])->name('profile.update');
Route::post('/password/update', [HomeController::class, 'password_update'])->name('password.update');
Route::post('/photo/update', [HomeController::class, 'photo_update'])->name('photo.update');

//Category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('delete.category');
Route::get('/delete/hard/category/{category_id}', [CategoryController::class, 'category_hard_delete'])->name('delete.hard.category');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('edit.category');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'restore_category'])->name('restore.category');


//subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'edit_subcategory'])->name('edit.subcategory');
Route::post('/subcategory/update', [SubcategoryController::class, 'update_subcategory'])->name('subcategory.update');

//Product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/inventory/{product_id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/product/inventory/store', [ProductController::class, 'inventory_store'])->name('inventory.store');
Route::get('/product/variation', [ProductController::class, 'variation'])->name('variation');
Route::post('/product/variation/store', [ProductController::class, 'variation_store'])->name('variation.store');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');

//Cart
Route::post('/add/cart', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/add/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

//Customer Register
Route::post('/customer/store', [CustomerRegisterController::class, 'customer_store'])->name('customer.store');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update', [CustomerController::class, 'customer_profile_update'])->name('customer.profile.update');
Route::get('/my/order', [CustomerController::class, 'myorder'])->name('my.order');
Route::get('customer/email/veify/{token}', [CustomerController::class, 'customer_email_verify']);

//coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/add', [CouponController::class, 'add_coupon'])->name('add.coupon');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/checkout/store', [CheckoutController::class, 'checkout_store'])->name('checkout.store');
Route::get('/order/success/{abc}', [CheckoutController::class, 'order_success'])->name('order.success');

//Orders
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status', [OrderController::class, 'order_status'])->name('order.status');

//stripe
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//invoice
Route::get('/download/invoice/{order_id}', [CustomerController::class, 'download_invoice'])->name('download.invoice');

//Role manager
Route::get('/role', [RoleController::class, 'role'])->name('role');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/add/role', [RoleController::class, 'add_role'])->name('add.role');
Route::post('/assign/role', [RoleController::class, 'assign_role'])->name('assign.role');
Route::get('/remove/role/{user_id}', [RoleController::class, 'remove_role'])->name('remove.role');



//Custom Pagination
Route::get('/custom/paginate/product', [CustomPaginateController::class, 'custom_paginate'])->name('custom.paginate');


//Reset Password
Route::get('password/reset/req/form', [CustomerController::class, 'password_reset_req_form'])->name('password.reset.req.form');
Route::post('password/reset/req/send', [CustomerController::class, 'password_reset_req_send'])->name('pass.reset.req.send');
Route::get('/customer/password/reset/form/{token}', [CustomerController::class, 'pass_reset_form'])->name('customer.pass_reset_form');
Route::post('/customer/reset/pass/confirm', [CustomerController::class, 'pass_reset_confirm'])->name('customer.pass.reset.confirm');

//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');


//Social Login

Route::get('/github/redirect', [GithubController::class, 'github_redirect'])->name('github.redirect');
Route::get('/github/callback', [GithubController::class, 'github_callback'])->name('github.callback');

Route::get('/google/redirect', [GoogleController::class, 'google_redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'google_callback'])->name('google.callback');


//Review
Route::post('/review', [FrontendController::class, 'review_store'])->name('review.store');
