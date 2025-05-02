<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home.homepage');
});
Route::get('/register', function () {
    return view('home.register');
});
Route::get('/login', function () {
    return view('home.login')->name('login');
});
Route::get('/about', function () {
    return view('home.about');
});
Route::get('/shop', function () {
    return view('home.shop');
});


Route::get('/login', [App\Http\Controllers\HomePageController::class, 'login'])->name('lofin');

Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('homepage');
Route::get('/collections', [App\Http\Controllers\HomePageController::class, 'collections'])->name('collections');


Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');


// Product routes
Route::prefix('products')->group(function () {
    // Product listings with filters
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

    // Individual product page
    // Route to show all products in a category
    Route::get('/category/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

    // Route to show a single product
    Route::get('/product/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
    // API endpoints for components
    Route::get('/featured', [App\Http\Controllers\ProductController::class, 'featured'])->name('products.featured');
    Route::get('/bestsellers', [App\Http\Controllers\ProductController::class, 'bestsellers'])->name('products.bestsellers');
});

// Category routes
Route::get('/categories/{category}', function (App\Models\Category $category) {
    return redirect()->route('products.index', ['category' => $category->slug]);
})->name('categories.show');

// Fallback for 404 pages
Route::fallback(function () {
    return view('errors.404');
});


// Cart routes
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/data', [App\Http\Controllers\CartController::class, 'getCartData'])->name('cart.data');

// Favorites routes
Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'listFavorites'])->name('favorites.list');
Route::get('/favorites/count', [App\Http\Controllers\FavoriteController::class, 'getFavoritesCount'])->name('favorites.count');
