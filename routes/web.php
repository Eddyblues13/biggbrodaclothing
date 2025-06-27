<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home.homepage');
});

Route::get('/about', function () {
    return view('home.about');
});



// Registration Routes
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.submit');

// Login Routes
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\ResetPasswordController::class, 'reset'])
    ->name('password.update');




// Checkout route with auth middleware
Route::middleware(['user'])->group(function () {

    Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'index'])->name('profile');

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
        Route::post('/step/{step}', [App\Http\Controllers\CheckoutController::class, 'saveStep'])->name('save-step');
    });
});



Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('homepage');
Route::get('/shop', [App\Http\Controllers\HomePageController::class, 'shop'])->name('shop');
Route::get('/collections', [App\Http\Controllers\HomePageController::class, 'collections'])->name('collections');
Route::post('/subscribe', [App\Http\Controllers\HomePageController::class, 'addSubscribers']);


Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');


Route::prefix('products')->group(function () {
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
});

// Product routes
Route::prefix('products')->group(function () {
    // Product listings with filters
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/color/{color}', [App\Http\Controllers\ProductController::class, 'filterByColor'])->name('products.byColor');
    Route::get('/brand/{brand}', [App\Http\Controllers\ProductController::class, 'filterByBrand'])->name('shop.brand');
    // routes/web.php
    Route::get('/products/filter', [App\Http\Controllers\ProductController::class, 'filter']);



    // Individual product page
    Route::get('/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    // Route to show all products in a category
    Route::get('/category/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

    // Route to show a single product
    Route::get('/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
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
Route::get('/view-cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');


// Cart Routes
Route::prefix('cart')->group(function () {
    Route::post('/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart.view');
    Route::get('/data', [App\Http\Controllers\CartController::class, 'getCartData'])->name('cart.data');
});
// Favorites routes
Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'listFavorites'])->name('favorites.list');
Route::get('/favorites/count', [App\Http\Controllers\FavoriteController::class, 'getFavoritesCount'])->name('favorites.count');


Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');








Route::get('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login.submit');



// Admin Routes
Route::prefix('admin')->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');

    // Protecting admin routes using the 'admin' middleware
    Route::middleware(['admin'])->group(function () { // Admin Profile Routes
        Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.home');
        // Dashboard Routes

        Route::get('/dashboard/analytics', [App\Http\Controllers\Admin\AdminController::class, 'getAnalytics'])->name('admin.dashboard.analytics');


        // User Management Routes
        Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.users.index');
        // ... other user routes



        // Settings Route
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('admin.settings');


        // Admin User Routes
        Route::prefix('users')->group(function () {
            // manage user CRUD routes
            Route::get('/', [App\Http\Controllers\Admin\ManageUserController::class, 'index'])->name('admin.users.index');
            Route::get('/users/create', [App\Http\Controllers\Admin\ManageUserController::class, 'create'])->name('admin.users.create');
            Route::post('/users', [App\Http\Controllers\Admin\ManageUserController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{user}', [App\Http\Controllers\Admin\ManageUserController::class, 'show'])->name('admin.user.view');

            // AJAX Routes
            Route::get('/getusers', [App\Http\Controllers\Admin\ManageUserController::class, 'getUsers'])->name('admin.getusers');
            Route::post('/users/toggle-status', [App\Http\Controllers\Admin\ManageUserController::class, 'toggleUserStatus'])->name('admin.user.toggleUserStatus');
            Route::post('/users/toggle-email-status', [App\Http\Controllers\Admin\ManageUserController::class, 'toggleEmailStatus'])->name('admin.user.toggleEmailStatus');
            Route::post('/users/send-mass-email', [App\Http\Controllers\Admin\ManageUserController::class, 'sendMassEmail'])->name('admin.users.sendMassEmail');
        });



        Route::prefix('products')->group(function () {
            // manage user CRUD routes
            Route::get('/', [App\Http\Controllers\Admin\ManageProductController::class, 'index'])->name('admin.products');
            Route::get('/users/create', [App\Http\Controllers\Admin\ManageProductController::class, 'create'])->name('admin.users.create');
            Route::post('/users', [App\Http\Controllers\Admin\ManageProductController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{user}', [App\Http\Controllers\Admin\ManageProductController::class, 'show'])->name('admin.user.view');
            Route::get('/create-products', [App\Http\Controllers\Admin\ManageProductController::class, 'CreateProducts'])->name('create.products');
            Route::delete('/products/{product}', [App\Http\Controllers\Admin\ManageProductController::class, 'destroy'])->name('products.destroy');
        });


        Route::prefix('category')->group(function () {
            // manage user CRUD routes
            Route::get('/', [App\Http\Controllers\Admin\ManageCategoryController::class, 'index'])->name('admin.category');
            Route::get('/users/create', [App\Http\Controllers\Admin\ManageCategoryController::class, 'create'])->name('admin.users.create');
            Route::post('/users', [App\Http\Controllers\Admin\ManageCategoryController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{user}', [App\Http\Controllers\Admin\ManageCategoryController::class, 'show'])->name('admin.user.view');
            Route::get('/create-category', [App\Http\Controllers\Admin\ManageCategoryController::class, 'CreateCategory'])->name('create.category');
        });





        Route::get('/change/user/password/page/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showResetPasswordForm'])->name('admin.change.user.password.page');
        Route::post('/user-password-reset', [App\Http\Controllers\Admin\AdminController::class, 'resetPassword'])->name('admin.user.password_reset');

        Route::post('/admin/update-user', [App\Http\Controllers\Admin\AdminController::class, 'adminUpdateUser'])->name('admin.updateUser');
        Route::get('/reset-password/{user}', [App\Http\Controllers\Admin\AdminController::class, 'resetUserPassword'])->name('reset.password');
        Route::match(['get', 'post'], '/send-mail', [App\Http\Controllers\Admin\AdminController::class, 'sendMail'])->name('admin.send.mail');
        Route::get('/{user}/impersonate',  [App\Http\Controllers\Admin\AdminController::class, 'impersonate'])->name('users.impersonate');
        Route::get('/leave-impersonate',  [App\Http\Controllers\Admin\AdminController::class, 'leaveImpersonate'])->name('users.leave-impersonate');
        Route::get('/delete-user/{user}',  [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('delete.user');
    });
});
