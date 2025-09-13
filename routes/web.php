<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\HeroController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\TitleController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Home */
Route::get('/', function () {
    return view('home.index');
})->name('home');

/* Dashboard */
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Profile */
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

// User Profile
Route::middleware('auth')->group(function () {
  Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
  Route::post('/profile/store', [AdminController::class, 'profileStore'])->name('profile.store');
  Route::post('/admin/password/update', [AdminController::class, 'passwordUpdate'])->name('admin.password.update');
});

// User Connecté
Route::middleware('auth')->group(function () {
  // User Review
  Route::controller(ReviewController::class)->group(function () {
    Route::get('/all/reviews', 'allReviews')->name('all.reviews');
    Route::get('/add/review', 'addReview')->name('add.review');
    Route::post('/store/review', 'storeReview')->name('store.review');
    Route::get('/edit/review/{id}', 'editReview')->name('edit.review');
    Route::post('/update/review', 'updateReview')->name('update.review');
    Route::get('/delete/review/{id}', 'deleteReview')->name('delete.review');
  });

  // Hero Section
  Route::controller(HeroController::class)->group(function () {
    Route::get('/get/hero', 'getHero')->name('get.hero');
    Route::post('/update/hero', 'updateHero')->name('update.hero');
    // Edit Hero with Javascript
    Route::post('/edit-hero/{id}', 'editHero');
  });

  // Title <H2> Change in interface with Javascript
  Route::controller(TitleController::class)->group(function () {
    Route::post('/edit-features/{id}', 'editFeatures');
    Route::post('/edit-reviews/{id}', 'editReviews');
    Route::post('/edit-faq/{id}', 'editFaq');
  });

  // Features
  Route::controller(HomeController::class)->group(function () {
    Route::get('/all/features', 'allFeatures')->name('all.features');
    Route::get('/add/feature', 'addFeature')->name('add.feature');
    Route::post('/store/feature', 'storeFeature')->name('store.feature');
    Route::get('/edit/feature/{id}', 'editFeature')->name('edit.feature');
    Route::post('/update/feature', 'updateFeature')->name('update.feature');
    Route::get('/delete/feature/{id}', 'deleteFeature')->name('delete.feature');
  });

  // Tool Quality - Tabs - Video Sections in Homepage
  Route::controller(HomeController::class)->group(function () {
    Route::get('/get/tool', 'getTool')->name('get.tool');
    Route::post('/update/tool', 'updateTool')->name('update.tool');
    Route::get('/get/tabs', 'getTabs')->name('get.tabs');
    Route::post('/update/tabs', 'updateTabs')->name('update.tabs');
    Route::get('/get/video', 'getVideo')->name('get.video');
    Route::post('/update/video', 'updateVideo')->name('update.video');
  });

  // Process Section
  Route::controller(HomeController::class)->group(function () {
    Route::get('/all/process', 'allProcess')->name('all.process');
    Route::get('/add/process', 'addProcess')->name('add.process');
    Route::post('/store/process', 'storeProcess')->name('store.process');
    Route::get('/edit/process/{id}', 'editProcess')->name('edit.process');
    Route::post('/update/process', 'updateProcess')->name('update.process');
    Route::get('/delete/process/{id}', 'deleteProcess')->name('delete.process');
    // Edit Process in Homepage with Javascript
    Route::post('/update-process-data/{id}', 'updateProcessData');
  });

  // FAQ Section
  Route::controller(HomeController::class)->group(function () {
    Route::get('/all/faqs', 'allFaqs')->name('all.faqs');
    Route::get('/add/faq', 'addFaq')->name('add.faq');
    Route::post('/store/faq', 'storeFaq')->name('store.faq');
    Route::get('/edit/faq/{id}', 'editFaq')->name('edit.faq');
    Route::post('/update/faq', 'updateFaq')->name('update.faq');
    Route::get('/delete/faq/{id}', 'deleteFaq')->name('delete.faq');
  });

  // CTA Section (update datas - title, description, image - with Javascript)
  Route::controller(HomeController::class)->group(function () {
    Route::post('/update-cta/{id}', 'updateCta');
    Route::post('/update-cta-image/{id}', 'updateCtaImage');
  });

  // Team Page
  Route::controller(TeamController::class)->group(function () {
    Route::get('/all/teams', 'allTeams')->name('all.teams');
    Route::get('/add/team', 'addTeam')->name('add.team');
    Route::post('/store/team', 'storeTeam')->name('store.team');
    Route::get('/edit/team/{id}', 'editTeam')->name('edit.team');
    Route::post('/update/team', 'updateTeam')->name('update.team');
    Route::get('/delete/team/{id}', 'deleteTeam')->name('delete.team');
  });

  // About Page
  Route::controller(FrontendController::class)->group(function () {
    Route::get('/get/about', 'getAbout')->name('get.about');
    Route::post('/update/about', 'updateAbout')->name('update.about');
  });

  // Blog Page
  Route::controller(BlogController::class)->group(function () {
    Route::get('/blog/category', 'blogCategory')->name('all.blog.category');
    Route::post('/store/blog/category', 'storeBlogCategory')->name('store.blog.category');
    Route::get('/edit/blog/category/{id}', 'editBlogCategory');
    Route::post('/update/blog/category', 'updateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'deleteBlogCategory')->name('delete.blog.category');
  });

});

// User non connecté
Route::get('/team', [FrontendController::class, 'ourTeam'])->name('our.team');
Route::get('/about', [FrontendController::class, 'aboutUs'])->name('about.us');

