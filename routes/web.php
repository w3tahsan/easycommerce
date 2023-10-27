<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventorycontroller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripePaymentController;

//frontned
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::get('/customer/login/register', [FrontendController::class, 'customer_login_register'])->name('customer.login.register');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');

Auth::routes();
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Users
Route::get('/users', [HomeController::class, 'users'])->name('users');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');
Route::post('/add/user', [UserController::class, 'add_user'])->name('add.user');

//User Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'profile_update'])->name('profile.update');
Route::post('/profile/photo/update', [ProfileController::class, 'profile_photo_update'])->name('profile.photo.update');

//category
Route::get('/add/category', [CategoryController::class, 'category'])->name('add.category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/soft/delete/{category_id}', [CategoryController::class, 'category_soft_delete'])->name('category.soft.delete');
Route::get('/trash/category', [CategoryController::class, 'trash_category'])->name('trash.category');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/permanent/delete/{category_id}', [CategoryController::class, 'permanent_delete'])->name('permanent.delete');
Route::post('/category/check/delete', [CategoryController::class, 'checked_delete'])->name('checked.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');

//subCategory
Route::get('/subcategory', [SubcategoryController::class, 'sub_category'])->name('sub.category');
Route::post('/subcategory/store', [SubcategoryController::class, 'sub_category_store'])->name('sub.category.store');
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'subcategory_delete'])->name('sub.category.delete');
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'subcategory_edit'])->name('sub.category.edit');
Route::post('/subcategory/update', [SubcategoryController::class, 'subcategory_update'])->name('sub.category.update');

//Product
Route::get('/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');


//Product Variation
Route::get('/variation', [Inventorycontroller::class, 'variation'])->name('variation');
Route::post('/color/store', [Inventorycontroller::class, 'color_store'])->name('color.store');
Route::get('/color/delete/{color_id}', [Inventorycontroller::class, 'color_delete'])->name('color.delete');
Route::post('/size/store', [Inventorycontroller::class, 'size_store'])->name('size.store');
Route::get('/product/inventory/{product_id}', [Inventorycontroller::class, 'product_inventory'])->name('product.inventory');
Route::post('/inventory/store', [Inventorycontroller::class, 'inventory_store'])->name('inventory.store');


//Customer Authentication
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update', [CustomerController::class, 'customer_profile_update'])->name('profile.update');


//Cart
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

//Coupons
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/checkout/store', [CheckoutController::class, 'checkout_store'])->name('checkout.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');


//Myorder
Route::get('/my/order', [CustomerController::class, 'my_order'])->name('my.order');
Route::get('/order/list', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status/update', [OrderController::class, 'order_status_update'])->name('order.status.update');
Route::get('/invoice/download/{order_id}', [OrderController::class, 'invoice_download'])->name('invoice.download');

// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Stripe
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


//product review
Route::post('/product/review', [CustomerController::class, 'preoduct_review'])->name('product.review');

//Role Manager
Route::get('/role/manager', [RoleController::class, 'role_manager'])->name('role.manager');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleController::class, 'role_store'])->name('role.store');
Route::post('/assign/role', [RoleController::class, 'assign_role'])->name('assign.role');
Route::get('/remove/user/role/{user_id}', [RoleController::class, 'remove_user_role'])->name('remove.user.role');
Route::get('/remove/role/permission/{role_id}', [RoleController::class, 'remove_role_permission'])->name('remove.role.permission');


//Password Reset
Route::get('/forgot/password', [PasswordResetController::class, 'forgot_password'])->name('forgot.password');
Route::post('/password/req/send', [PasswordResetController::class, 'password_req_send'])->name('password.req.send');
Route::get('/password/reset/form/{token}', [PasswordResetController::class, 'password_reset_form'])->name('password.reset.form');
Route::post('/password/reset/update', [PasswordResetController::class, 'password_reset_update'])->name('password.reset.update');

//Email Verify
Route::get('/customer/email/verify/{token}', [CustomerRegisterController::class, 'email_verify'])->name('customer.email.verify');
Route::get('email/verify/req', [CustomerRegisterController::class, 'email_verify_req'])->name('email_verify_req');
Route::post('verify/email/req/send', [CustomerRegisterController::class, 'email_verify_req_send'])->name('email.verify.req.send');



//Faq
Route::resource('faq', FaqController::class);
