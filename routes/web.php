<?php

use App\Http\Controllers\Backend\AuthorController;
use App\Http\Controllers\Backend\BlogPostController;
use App\Http\Controllers\Backend\BloodGroupController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactMessageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DonorController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\PaymentsController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\CategoryListController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DonorRegistationController;
use App\Http\Controllers\Frontend\ProductsController;
use App\Http\Controllers\Frontend\WishlistController;

// Frontend

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/donors', [HomeController::class, 'allDonors'])->name('frontend.donors');
Route::get('/blood/{slug}', [HomeController::class, 'bloodGroup'])
    ->name('blood.group');

// Home page showing all blogs
Route::get('/blog', [BlogController::class, 'index'])->name('home');
// Single blog view by slug
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');

// category wise blog listing
Route::get('/category/{slug}', [CategoryListController::class, 'show'])->name('category.show');

Route::get('/about-us', [AboutUsController::class, 'aboutUs'])->name('aboutUs');
Route::get('/contact-us', [ContactController::class, 'contact'])->name('contactUs');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/be-a-fighter-register', [DonorRegistationController::class, 'index'])
    ->name('donor.frontend.index');

Route::post('/be-a-fighter-register', [DonorRegistationController::class, 'submit'])
    ->name('donor.frontend.submit');

Route::get('/help-for-donate', [PaymentsController::class, 'index'])->name('donor.donation.index');
Route::post('/help-for-donate/store', [PaymentsController::class, 'store'])->name('donor.donation.store');

// Products
Route::get('/product', [ProductsController::class, 'index'])->name('product.front.index');
Route::get('/product/{slug}', [ProductsController::class, 'show'])->name('product.front.show');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'store'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::get('/remove/{id}', [CartController::class, 'remove'])->name('remove');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place');
// Wishlist

// Backend

// Blog Post 
Route::prefix('admin/blog-post')->name('blog.')->group(function () {
    Route::get('/', [BlogPostController::class, 'index'])->name('list');
    Route::get('/data', [BlogPostController::class, 'getDataTable'])
    ->name('data');
    Route::get('create', [BlogPostController::class, 'create'])->name('create');
    Route::post('store', [BlogPostController::class, 'store'])->name('store');
    Route::get('edit/{id}', [BlogPostController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [BlogPostController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [BlogPostController::class, 'destroy'])->name('destroy');
});

// Category
Route::prefix('admin/category')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('list');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

// contact messages
Route::prefix('admin/contact')->name('contact.')->group(function () {
    Route::get('/', [ContactMessageController::class, 'index'])->name('list');
    Route::get('show/{id}', [ContactMessageController::class, 'show'])->name('show');
    Route::delete('delete/{id}', [ContactMessageController::class, 'destroy'])->name('destroy');
});

// faq
Route::prefix('admin/faq')->name('faq.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('list');
    Route::get('datatable', [FaqController::class, 'getDataTable'])->name('datatable');
    Route::get('create', [FaqController::class, 'create'])->name('create');
    Route::post('store', [FaqController::class, 'store'])->name('store');
    Route::get('{id}/edit', [FaqController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [FaqController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [FaqController::class, 'destroy'])->name('delete');
});

// author
Route::prefix('admin/author')->name('author.')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('list');
    Route::get('create', [AuthorController::class, 'create'])->name('create');
    Route::post('store', [AuthorController::class, 'store'])->name('store');
    Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [AuthorController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [AuthorController::class, 'destroy'])->name('destroy');
  }); 
  
// setting
Route::prefix('admin/setting')->name('setting.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('list');
    Route::get('edit', [SettingController::class, 'index'])->name('edit');
    Route::patch('update', [SettingController::class, 'update'])->name('update');
});

// blood-group
Route::prefix('admin/blood-group')->name('blood-group.')->group(function () {
    Route::get('/', [BloodGroupController::class, 'index'])->name('list');
    Route::post('store', [BloodGroupController::class, 'store'])->name('store');
    Route::get('edit/{id}', [BloodGroupController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [BloodGroupController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [BloodGroupController::class, 'destroy'])->name('destroy');
});

// Doneor Management
Route::prefix('admin/donor')->name('donor.')->group(function () {
    Route::get('/', [DonorController::class, 'index'])->name('list');
    Route::get('create', [DonorController::class, 'create'])->name('create'); // <-- fix
    Route::get('datatable', [DonorController::class, 'getDataTable'])->name('datatable');
    Route::post('store', [DonorController::class, 'store'])->name('store');
    Route::get('edit/{id}', [DonorController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [DonorController::class, 'update'])->name('update');
    Route::patch('approve/{id}', [DonorController::class, 'approve'])->name('approve');
    Route::delete('delete/{id}', [DonorController::class, 'destroy'])->name('destroy');
});

// Payment Management
Route::prefix('admin/payment')->name('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('list');
    Route::get('/datatable', [PaymentController::class, 'datatable'])->name('datatable');
    Route::patch('approve/{id}', [PaymentController::class, 'approve'])->name('approve');
    Route::delete('delete/{id}', [PaymentController::class, 'destroy'])->name('destroy');
});


Route::prefix('admin/product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('list');
    Route::get('datatable', [ProductController::class, 'getDataTable'])->name('datatable');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
