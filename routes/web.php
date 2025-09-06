<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/order/free/{product}', [OrderController::class, 'showFreeForm'])->name('order.free');
Route::get('/order/paid/{product}', [OrderController::class, 'showPaidForm'])->name('order.paid');
Route::post('/order/free', [OrderController::class, 'storeFree'])->name('order.store-free');
Route::post('/order/paid', [OrderController::class, 'storePaid'])->name('order.store-paid');
Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment');
Route::get('/payment-success/{order}', [OrderController::class, 'paymentSuccess'])->name('payment.success');

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/forgot-password', [AdminController::class, 'showForgotPassword'])->name('admin.forgot-password');
Route::post('/admin/forgot-password', [AdminController::class, 'forgotPassword']);
Route::get('/admin/reset-password/{token}', [AdminController::class, 'showResetPassword'])->name('admin.reset-password');
Route::post('/admin/reset-password', [AdminController::class, 'resetPassword']);

// Cart routes
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'show'])->name('cart.show');
Route::post('/cart/update/{item}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{item}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('checkout.process');

// Questionnaire routes
Route::get('/questionnaire', [App\Http\Controllers\QuestionnaireSessionController::class, 'show'])->name('questionnaire.show');
Route::post('/questionnaire', [App\Http\Controllers\QuestionnaireSessionController::class, 'store'])->name('questionnaire.store');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/order/{id}', [AdminController::class, 'showOrder'])->name('admin.order.show');
    Route::get('/admin/order/{id}/confirm', [AdminController::class, 'confirmOrder'])->name('admin.order.confirm');
    Route::get('/admin/order/{id}/complete', [AdminController::class, 'completeOrder'])->name('admin.order.complete');
    
    // Product management
    Route::resource('admin/products', App\Http\Controllers\AdminProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]
    ]);
    
    // Admin profile management
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password');
    Route::post('/admin/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create-admin');
    
    // Admin management
    Route::resource('admin/admins', App\Http\Controllers\AdminManagementController::class, [
        'names' => [
            'index' => 'admin.admins.index',
            'create' => 'admin.admins.create',
            'store' => 'admin.admins.store',
            'show' => 'admin.admins.show',
            'edit' => 'admin.admins.edit',
            'update' => 'admin.admins.update',
            'destroy' => 'admin.admins.destroy'
        ]
    ]);
    
    // Questionnaire report
    Route::get('/admin/questionnaire-report', [AdminController::class, 'questionnaireReport'])->name('admin.questionnaire.report');
});
