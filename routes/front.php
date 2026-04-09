<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CustomerAuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SingleProductController;
use illuminate\Support\Facades\Route;

// Customer Auth

Route::middleware('guest.customer')->group(function(){
    Route::get('/login', [CustomerAuthController::class, 'loginShow'])->name('customer.login');
    Route::get('/register', [CustomerAuthController::class, 'registerShow'])->name('customer.register');

    Route::post('/register/process', [CustomerAuthController::class, 'registerProcess'])->name('customer.register.process');
    Route::post('/login/process', [CustomerAuthController::class, 'loginProcess'])->name('customer.login.process');

    Route::get('/', [HomeController::class, 'homePage'])->name('home.index');
    Route::get('/product/shop/{id}', [HomeController::class, 'productCategory'])->name('product.category');
    Route::get('product/view', [HomeController::class, 'viewProduct'])->name('product.view');

    Route::get('/product/single/{id}', [SingleProductController::class, 'singleProduct'])->name('product.single');

    Route::get('/send', [CustomerAuthController::class, 'sendEmail'])->name('send.email.show');
    Route::post('/send/process', [CustomerAuthController::class, 'sendEmailProcess'])->name('send.email.process');

    Route::get('/verify/{token}', [CustomerAuthController::class, 'codeVerify'])->name('code.verify');
    Route::post('/verify/process', [CustomerAuthController::class, 'codeVerifyProcess'])->name('code.verify.process');

    Route::get('/reset/{code}/{token}', [CustomerAuthController::class, 'resetPassword'])->name('reset.password.show');
    Route::post('/reset/process', [CustomerAuthController::class, 'resetPasswordProcess'])->name('reset.password.process');

});

Route::middleware('auth.customer')->group(function(){
    Route::name('cart.')->group(function(){
        Route::get('/cart/view', [CartController::class, 'index'])->name('list');
        Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('add');
        Route::get('/cart/remove/{id}',[CartController::class,'remove'])->name('remove');
        Route::post('cart/update',[CartController::class,'update'])->name('update');
    });

    Route::name('checkout.')->group(function(){
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('index');
    });
});