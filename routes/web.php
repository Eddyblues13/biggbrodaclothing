<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageProductController;
use App\Http\Controllers\Admin\ManageCategoryController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\ManageSubscriberController;
use App\Http\Controllers\Auth\AdminLoginController;



// Public Routes
Route::get('/', function () {
    return view('home.homepage');
});

Route::get('/about', function () {
    return view('home.about');
});

Route::get('/our-store', function () {
    return view('home.our-store');
});

// Authentication Routes
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.submit');

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

// User Dashboard Routes
Route::middleware(['user'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'index'])->name('profile');
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/addresses', [App\Http\Controllers\AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [App\Http\Controllers\AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [App\Http\Controllers\AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [App\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [App\Http\Controllers\AddressController::class, 'setDefault'])->name('addresses.set-default');
    
    Route::get('/wishlist', [App\Http\Controllers\FavoriteController::class, 'listFavorites'])->name('wishlist.index');
});

// Frontend Routes
Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('homepage');
Route::get('/shop', [App\Http\Controllers\HomePageController::class, 'shop'])->name('shop');
Route::get('/collections', [App\Http\Controllers\HomePageController::class, 'collections'])->name('collections');
Route::post('/subscribe', [App\Http\Controllers\HomePageController::class, 'addSubscribers'])->name('subscribe.add');

// Category Routes
Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
Route::prefix('products')->group(function () {
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
});

// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/color/{color}', [App\Http\Controllers\ProductController::class, 'filterByColor'])->name('products.byColor');
    Route::get('/brand/{brand}', [App\Http\Controllers\ProductController::class, 'filterByBrand'])->name('shop.brand');
    Route::get('/products/filter', [App\Http\Controllers\ProductController::class, 'filter']);
    Route::get('/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::get('/category/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
    Route::get('/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
    Route::get('/featured', [App\Http\Controllers\ProductController::class, 'featured'])->name('products.featured');
    Route::get('/bestsellers', [App\Http\Controllers\ProductController::class, 'bestsellers'])->name('products.bestsellers');
});

// Category redirect
Route::get('/categories/{category}', function (App\Models\Category $category) {
    return redirect()->route('products.index', ['category' => $category->slug]);
})->name('categories.show');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::post('/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart.view');
    Route::get('/data', [App\Http\Controllers\CartController::class, 'getCartData'])->name('cart.data');
    // Cart routes
Route::post('/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/data', [App\Http\Controllers\CartController::class, 'getCartData'])->name('cart.data');
Route::get('/view-cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
});

// Favorites Routes
Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'listFavorites'])->name('favorites.list');
Route::get('/favorites/count', [App\Http\Controllers\FavoriteController::class, 'getFavoritesCount'])->name('favorites.count');

// Checkout Routes
Route::middleware(['user'])->group(function () {
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
        Route::post('/step/{step}', [App\Http\Controllers\CheckoutController::class, 'saveStep'])->name('save-step');
    });

    Route::get('/payment/callback', [App\Http\Controllers\CheckoutController::class, 'handleCallback'])->name('payment.callback');
    Route::get('/order/receipt/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'orderReceipt'])->name('order.receipt');
});

// Admin Authentication Routes
Route::get('admin/login', [AdminLoginController::class, 'adminLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Admin Routes
// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Protecting admin routes using the 'admin' middleware
    Route::middleware(['admin'])->group(function () {
        
        // Dashboard Routes
        Route::get('/dashboard', [AdminController::class, 'index'])->name('home');
        Route::get('/home', [AdminController::class, 'index'])->name('home');
        Route::get('/dashboard/analytics', [AdminController::class, 'getAnalytics'])->name('dashboard.analytics');

 // User Management Routes
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [ManageUserController::class, 'index'])->name('index');
    Route::get('/create', [ManageUserController::class, 'create'])->name('create');
    Route::post('/', [ManageUserController::class, 'store'])->name('store');
    Route::get('/{user}', [ManageUserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [ManageUserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [ManageUserController::class, 'update'])->name('update');
    Route::delete('/{user}', [ManageUserController::class, 'destroy'])->name('destroy');
    Route::post('/{user}/toggle-verification', [ManageUserController::class, 'toggleVerification'])->name('toggle-verification');
    Route::post('/bulk-action', [ManageUserController::class, 'bulkAction'])->name('bulk-action');
});

// Subscriber Management Routes
Route::prefix('subscribers')->name('subscribers.')->group(function () {
    Route::get('/', [ManageSubscriberController::class, 'index'])->name('index');
    Route::get('/create', [ManageSubscriberController::class, 'create'])->name('create');
    Route::post('/', [ManageSubscriberController::class, 'store'])->name('store');
    Route::get('/{subscriber}/edit', [ManageSubscriberController::class, 'edit'])->name('edit');
    Route::put('/{subscriber}', [ManageSubscriberController::class, 'update'])->name('update');
    Route::delete('/{subscriber}', [ManageSubscriberController::class, 'destroy'])->name('destroy');
    Route::post('/{subscriber}/toggle-status', [ManageSubscriberController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/bulk-action', [ManageSubscriberController::class, 'bulkAction'])->name('bulk-action');
    Route::get('/export', [ManageSubscriberController::class, 'export'])->name('export');
    // Subscriber Email Routes
Route::get('/email', [ManageSubscriberController::class, 'showEmailForm'])->name('email-form');
Route::post('/send-bulk-email', [ManageSubscriberController::class, 'sendBulkEmail'])->name('send-bulk-email');
Route::get('/{subscriber}/email', [ManageSubscriberController::class, 'showIndividualEmailForm'])->name('individual-email-form');
Route::post('/{subscriber}/send-email', [ManageSubscriberController::class, 'sendIndividualEmail'])->name('send-individual-email');
});



// Category Management Routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [ManageCategoryController::class, 'index'])->name('index');
    Route::get('/create', [ManageCategoryController::class, 'create'])->name('create');
    Route::post('/', [ManageCategoryController::class, 'store'])->name('store');
    Route::get('/{category}', [ManageCategoryController::class, 'show'])->name('show');
    Route::get('/{category}/edit', [ManageCategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [ManageCategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [ManageCategoryController::class, 'destroy'])->name('destroy');
    Route::post('/{category}/toggle-status', [ManageCategoryController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/bulk-action', [ManageCategoryController::class, 'bulkAction'])->name('bulk-action');
});

// Legacy route for backward compatibility
Route::get('/category', [ManageCategoryController::class, 'index'])->name('category');
Route::get('/create-category', [ManageCategoryController::class, 'create'])->name('create.category');

        // Product Management Routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ManageProductController::class, 'index'])->name('index');
            Route::get('/create', [ManageProductController::class, 'create'])->name('create');
            Route::post('/', [ManageProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [ManageProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ManageProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ManageProductController::class, 'destroy'])->name('destroy');
            Route::post('/{product}/toggle-status', [ManageProductController::class, 'toggleStatus'])->name('toggle-status');
        });

 

// Order Management Routes
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [ManageOrderController::class, 'index'])->name('index');
    Route::get('/{order}', [ManageOrderController::class, 'show'])->name('show');
    Route::put('/{order}/status', [ManageOrderController::class, 'updateStatus'])->name('update-status');
    Route::post('/{order}/approve', [ManageOrderController::class, 'approve'])->name('approve');
    Route::post('/{order}/decline', [ManageOrderController::class, 'decline'])->name('decline');
    Route::put('/order-items/{orderItem}', [ManageOrderController::class, 'updateOrderItem'])->name('update-item');
    Route::delete('/{order}', [ManageOrderController::class, 'destroy'])->name('destroy');
    Route::post('/bulk-action', [ManageOrderController::class, 'bulkAction'])->name('bulk-action');
});

        // Settings Route
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');

        // Additional Admin Routes (Legacy - for backward compatibility)
        Route::get('/users', [ManageUserController::class, 'index'])->name('users.index'); // Legacy route
        Route::get('/products', [ManageProductController::class, 'index'])->name('products'); // Legacy route
        
    
        Route::get('/create-products', [ManageProductController::class, 'create'])->name('create.products'); // Legacy route
       
        // Password Management Routes
        Route::get('/change/user/password/page/{id}', [AdminController::class, 'showResetPasswordForm'])->name('change.user.password.page');
        Route::post('/user-password-reset', [AdminController::class, 'resetPassword'])->name('user.password_reset');
        Route::post('/update-user', [AdminController::class, 'adminUpdateUser'])->name('updateUser');
        Route::get('/reset-password/{user}', [AdminController::class, 'resetUserPassword'])->name('reset.password');

        // Email & Impersonation Routes
        Route::match(['get', 'post'], '/send-mail', [AdminController::class, 'sendMail'])->name('send.mail');
        Route::get('/{user}/impersonate', [AdminController::class, 'impersonate'])->name('users.impersonate');
        Route::get('/leave-impersonate', [AdminController::class, 'leaveImpersonate'])->name('users.leave-impersonate');
        Route::get('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('delete.user');
    });
});





// Fallback for 404 pages
Route::fallback(function () {
    return view('errors.404');
});