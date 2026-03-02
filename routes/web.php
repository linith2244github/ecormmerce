<?php

use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

// User Routers
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user/list', [UserController::class, 'list'])->name('user.list');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::post('/user/destroy', [UserController::class, 'destroy'])->name('user.destroy');

//Category Routers
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category/list', [CategoryController::class, 'list'])->name('category.list');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::post('/category/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::post('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::post('/category/upload', [CategoryController::class, 'upload'])->name('category.upload');
Route::post('/category/cancel', [CategoryController::class, 'cancelImage'])->name('category.cancel');

//Brand Routers
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::post('/brand/list', [BrandController::class, 'list'])->name('brand.list');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
Route::post('/brand/edit', [BrandController::class, 'edit'])->name('brand.edit');
Route::post('/brand/update', [BrandController::class, 'update'])->name('brand.update');
Route::post('/brand/destroy', [BrandController::class, 'destroy'])->name('brand.destroy');