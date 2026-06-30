<?php

use App\Http\Controllers\Admin\AdminAboutController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectMultiImageController;
use App\Http\Controllers\Admin\ServiceMultiImageController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SuccessController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\AdminInquiriesController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeFaqsController;
use App\Http\Controllers\HomeGalleryController;
use App\Http\Controllers\HomeProjectController;
use App\Http\Controllers\HomeServicesController;
use App\Http\Controllers\LetsTalkController;
use App\Http\Controllers\ProcessessController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AboutController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/about', [AboutController::class, 'index'])->name('about.home');
Route::resource('/all-services', HomeServicesController::class);
Route::resource('/portfolio', HomeProjectController::class);

// User route
Route::get('/our-teams', [LandingController::class, 'team'])->name('our.team');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/categories/{id}', [BlogController::class, 'category'])->name('blog.categories');
Route::post('/comment', [CommentController::class, 'store'])->middleware('throttle:3,1')->name('comment.store');
Route::resource('/all-projects', HomeProjectController::class)->only(['index', 'show', 'edit']);
Route::get('/faqs', HomeFaqsController::class)->name('home.faq');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.us');
Route::post('/contact-us', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.us.store');
Route::post('/lets-talk', [LetsTalkController::class, 'store'])->middleware('throttle:5,1')->name('lets.talk.store');
Route::resource('galleries', HomeGalleryController::class)->only(['index']);
Route::get('/processes', ProcessessController::class)->name('processes.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::resource('/dashboard', AdminController::class);
    Route::resource('/slider', SliderController::class);
    Route::resource('/services', ServicesController::class);
    Route::resource('/about', AdminAboutController::class);
    Route::resource('/why-us', WhyUsController::class);
    Route::resource('/team', TeamController::class);
    Route::resource('/faqs', FaqsController::class);
    Route::resource('/testimonial', TestimonialController::class);
    Route::resource('/partners', PartnerController::class);
    Route::resource('/success-story', SuccessController::class);
    Route::resource('/project-category', ProjectCategoryController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/blog-category', BlogCategoryController::class);
    Route::resource('/blog/posts', PostController::class);
    Route::resource('/project/multi-image', ProjectMultiImageController::class);
    Route::resource('/Services/multiple-image', ServiceMultiImageController::class);
    Route::resource('/contact', AdminContactController::class);
    Route::get('/contact-us', [ContactController::class, 'show'])->name('contact.us.show');
    Route::get('/contact-us/{id}', [ContactController::class, 'edit'])->name('contact.us.edit');
    Route::delete('/contact-us/{id}', [ContactController::class, 'destroy'])->name('contact.us.destroy');
    Route::get('/lets-talk', [LetsTalkController::class, 'show'])->name('lets.talk.show');
    Route::get('/lets-talk/{id}', [LetsTalkController::class, 'edit'])->name('lets.talk.edit');
    Route::delete('/lets-talk/{id}', [LetsTalkController::class, 'destroy'])->name('lets.talk.destroy');
    Route::get('/inquiries', [AdminInquiriesController::class, 'index'])->name('admin.inquiries.index');
    Route::get('/inquiries/export', [AdminInquiriesController::class, 'export'])->name('admin.inquiries.export');
    Route::resource('/gallery', GalleryController::class);
    Route::resource('/process', ProcessController::class);
});

