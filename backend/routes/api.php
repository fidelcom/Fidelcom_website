<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\MeController;
use App\Http\Controllers\Api\V1\Public\FaqController as PublicFaqController;
use App\Http\Controllers\Api\V1\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Api\V1\Public\BlogCategoryController as PublicBlogCategoryController;
use App\Http\Controllers\Api\V1\Public\InquiryController as PublicInquiryController;
use App\Http\Controllers\Api\V1\Public\ProjectCategoryController as PublicProjectCategoryController;
use App\Http\Controllers\Api\V1\Public\MenuController as PublicMenuController;
use App\Http\Controllers\Api\V1\Public\PageController as PublicPageController;
use App\Http\Controllers\Api\V1\Public\PartnerController as PublicPartnerController;
use App\Http\Controllers\Api\V1\Public\PostController as PublicPostController;
use App\Http\Controllers\Api\V1\Public\ProjectController as PublicProjectController;
use App\Http\Controllers\Api\V1\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Api\V1\Public\SettingsController as PublicSettingsController;
use App\Http\Controllers\Api\V1\Public\SliderController as PublicSliderController;
use App\Http\Controllers\Api\V1\Public\TeamController as PublicTeamController;
use App\Http\Controllers\Api\V1\Public\TestimonialController as PublicTestimonialController;
use App\Http\Controllers\Api\V1\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Api\V1\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Api\V1\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Api\V1\Admin\MediaController;
use App\Http\Controllers\Api\V1\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Api\V1\Admin\PageController as AdminPageController;
use App\Http\Controllers\Api\V1\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Api\V1\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\V1\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\V1\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\V1\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\V1\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Api\V1\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Api\V1\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\V1\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Api\V1\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\V1\Admin\ProjectCategoryController as AdminProjectCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    // ── Auth ──────────────────────────────────────────────────────────────────
    Route::post('auth/login',  LoginController::class)->middleware('throttle:5,1');
    Route::post('auth/logout', LogoutController::class)->middleware('auth:sanctum');
    Route::get('auth/user',    MeController::class)->middleware('auth:sanctum');

    // ── Public (unauthenticated) ──────────────────────────────────────────────
    Route::get('pages/{slug}',   [PublicPageController::class, 'show']);
    Route::get('posts',          [PublicPostController::class, 'index']);
    Route::get('posts/{slug}',   [PublicPostController::class, 'show']);
    Route::get('projects',       [PublicProjectController::class, 'index']);
    Route::get('projects/{project}', [PublicProjectController::class, 'show']);
    Route::get('services',       [PublicServiceController::class, 'index']);
    Route::get('services/{service}', [PublicServiceController::class, 'show']);
    Route::get('team',           PublicTeamController::class);
    Route::get('testimonials',   PublicTestimonialController::class);
    Route::get('faqs',           PublicFaqController::class);
    Route::get('gallery',        PublicGalleryController::class);
    Route::get('partners',       PublicPartnerController::class);
    Route::get('sliders',        PublicSliderController::class);
    Route::get('menus',          [PublicMenuController::class, 'index']);
    Route::get('settings',       PublicSettingsController::class);

    Route::post('inquiries',         [PublicInquiryController::class, 'contact'])
        ->middleware('throttle:5,1');
    Route::post('inquiries/contact', [PublicInquiryController::class, 'contact'])
        ->middleware('throttle:5,1');
    Route::post('inquiries/quote',   [PublicInquiryController::class, 'quote'])
        ->middleware('throttle:5,1');

    // ── Public categories ─────────────────────────────────────────────────────
    Route::get('blog-categories',    [PublicBlogCategoryController::class, 'index']);
    Route::get('project-categories', [PublicProjectCategoryController::class, 'index']);

    // ── Admin (authenticated + admin role required) ───────────────────────────
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

        // Dashboard stats
        Route::get('dashboard/stats', [AdminDashboardController::class, 'stats']);

        // Blog categories
        Route::apiResource('blog-categories', AdminBlogCategoryController::class);

        // Project categories
        Route::apiResource('project-categories', AdminProjectCategoryController::class);

        // Posts
        Route::apiResource('posts', AdminPostController::class);

        // Projects
        Route::apiResource('projects', AdminProjectController::class);

        // Services
        Route::apiResource('services', AdminServiceController::class);

        // Team
        Route::apiResource('team', AdminTeamController::class)->parameters(['team' => 'team']);

        // Testimonials
        Route::apiResource('testimonials', AdminTestimonialController::class);
        Route::patch('testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve']);

        // FAQs
        Route::apiResource('faqs', AdminFaqController::class);

        // Gallery
        Route::apiResource('gallery', AdminGalleryController::class)->parameters(['gallery' => 'gallery']);

        // Partners
        Route::apiResource('partners', AdminPartnerController::class);

        // Sliders
        Route::apiResource('sliders', AdminSliderController::class);

        // Menus
        Route::get('menus',                           [AdminMenuController::class, 'index']);
        Route::get('menus/{menu}',                    [AdminMenuController::class, 'show']);
        Route::patch('menus/{menu}/items',            [AdminMenuController::class, 'updateItems']);

        // Pages + blocks
        Route::apiResource('pages', AdminPageController::class);
        Route::post('pages/{page}/blocks',         [AdminPageController::class, 'storeBlock']);
        Route::patch('blocks/{block}',             [AdminPageController::class, 'updateBlock']);
        Route::delete('blocks/{block}',            [AdminPageController::class, 'destroyBlock']);
        Route::post('pages/{page}/blocks/reorder', [AdminPageController::class, 'reorderBlocks']);

        // Media library
        Route::get('media',             [MediaController::class, 'index']);
        Route::post('media/upload',     [MediaController::class, 'upload']);
        Route::patch('media/{medium}',  [MediaController::class, 'update']);
        Route::delete('media/{medium}', [MediaController::class, 'destroy']);

        // Inquiries
        Route::get('inquiries',                        [AdminInquiryController::class, 'index']);
        Route::get('inquiries/export',                 [AdminInquiryController::class, 'export']);
        Route::patch('inquiries/{inquiry}/status',     [AdminInquiryController::class, 'updateStatus']);
        Route::delete('inquiries/{inquiry}',           [AdminInquiryController::class, 'destroy']);

        // Settings
        Route::get('settings',   [AdminSettingsController::class, 'index']);
        Route::patch('settings', [AdminSettingsController::class, 'update']);
    });
});
