<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Logout
Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

// Two-Factor Authentication (2FA)
Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::get('/verify', [AdminController::class, 'showVerification'])->name('custom.verification.form');
Route::post('/verify', [AdminController::class, 'verificationVerify'])->name('custom.verification.verify');

// Profile
Route::middleware('auth')->group(function () {
  Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
  Route::post('/profile/store', [AdminController::class, 'profileStore'])->name('profile.store');
  Route::post('/admin/password/update', [AdminController::class, 'passwordUpdate'])->name('admin.password.update');
});

// Review
Route::middleware('auth')->group(function () {

  Route::controller(ReviewController::class)->group(function () {
    Route::get('/all/reviews', 'allReviews')->name('all.reviews');
    Route::get('/add/review', 'addReview')->name('add.review');
    Route::post('/store/review', 'storeReview')->name('store.review');
    Route::get('/edit/review/{id}', 'editReview')->name('edit.review');
    Route::post('/update/review', 'updateReview')->name('update.review');
    Route::get('/delete/review/{id}', 'deleteReview')->name('delete.review');
  });

});
