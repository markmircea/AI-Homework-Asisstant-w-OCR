<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\OCRMController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AskController;
use App\Http\Controllers\HistoryListController;
use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAskController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::get('register', [AuthenticatedSessionController::class, 'createRegistration'])
    ->name('register')
    ->middleware('guest');

Route::post('register', [AuthenticatedSessionController::class, 'storeRegistration'])
    ->name('register.store')
    ->middleware('guest');


Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('log-out', [AuthenticatedSessionController::class, 'destroy'])
    ->name('log-out');

// Show forgot password form
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Handle forgot password form submission
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Show reset password form
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

// Handle reset password form submission
Route::post('/reset-password', [PasswordResetController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

    Route::get('/email/verify', function () {
        return Inertia::render('Auth/VerifyEmail');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/index')->with('flash.success', 'Your email has been verified successfully!');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('flash.success', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Google OCR

Route::post('/ocr', [OCRMController::class, 'store'])
    ->name('ocr.store')
    ->middleware('auth');




// Google OAuth routes
Route::get('/login/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('login.google');

Route::get('/login/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);


// Route for authenticated users
Route::get('/index', [DashboardController::class, 'index'])
    ->middleware('auth', 'verified')
    ->name('dashboard');

// Route for non-authenticated users
Route::get('/index-no-auth', [DashboardController::class, 'indexNoAuth'])
    ->middleware('guest')
    ->name('indexNoAuth');


    Route::get('/public-ask', [PublicAskController::class, 'index'])->name('public.ask');
Route::post('/public-ask', [PublicAskController::class, 'store'])->name('public.ask.store');


    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');


// Redirect root to non-authenticated route if user is not authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('indexNoAuth');
    }
});


// Announcement

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('announcements', AnnouncementController::class)->except(['show', 'index']);
});

Route::post('/announcements/update-order', [AnnouncementController::class, 'updateOrder'])
    ->name('updateOrder')
    ->middleware('auth', 'verified');



// Users

Route::get('profile/{user}', [ProfileController::class, 'Index'])
    ->name('user.profile')
    ->middleware('auth', 'verified');

    Route::put('profile/{user}', [ProfileController::class, 'Update'])
    ->name('account.update')
    ->middleware('auth', 'verified');

    Route::delete('profile/{user}', [ProfileController::class, 'Destroy'])
    ->name('account.destroy')
    ->middleware('auth', 'verified');



    Route::get('users', [UsersController::class, 'Index'])
    ->name('Index')
   ->middleware('auth')
   ->middleware('owner');


Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth')
    ->middleware('owner');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth')
    ->middleware('owner');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth')
    ->middleware('owner');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth')
    ->middleware('owner');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth')
    ->middleware('owner');

    // Ask



Route::get('ask', [AskController::class, 'index'])
->name('ask')
->middleware('auth', 'verified');

Route::post('ask', [AskController::class, 'store'])
->name('ask.store')
->middleware('auth', 'verified');






// History

Route::middleware('auth', 'verified')->group(function () {
    Route::get('history', [HistoryController::class, 'index'])->name('history');
    Route::get('history/{announcement}/edit', [HistoryController::class, 'edit'])->name('history.edit');
    Route::put('history/{announcement}', [HistoryController::class, 'update'])->name('history.update');
    Route::delete('history/{announcement}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::post('history/update-order', [HistoryController::class, 'updateOrder'])->name('history.updateOrder');
});

Route::post('/history/{id}/send-email', [HistoryController::class, 'sendEmail'])
    ->name('history.sendEmail')
    ->middleware('auth', 'verified');

    Route::get('history-list', [HistoryListController::class, 'index'])
    ->name('history-list')
    ->middleware('auth', 'verified');


    Route::get('history-list/{announcement}/edit', [HistoryListController::class, 'edit'])
    ->name('history-list.edit')
    ->middleware('auth', 'verified');

    Route::put('history-list/{announcement}', [HistoryListController::class, 'update'])
    ->name('history-list.update')
    ->middleware('auth', 'verified');

Route::delete('history-list/{announcement}', [HistoryListController::class, 'destroy'])
    ->name('history-list.destroy')
    ->middleware('auth', 'verified');

Route::put('history-list/{announcement}/restore', [HistoryListController::class, 'restore'])
    ->name('history-list.restore')
    ->middleware('auth', 'verified');


    // Active Session

    Route::get('/user/active-sessions', [UserSessionController::class, 'getActiveSessions'])->middleware('auth', 'verified');

    Route::delete('/user/active-sessions/{sessionId}', [UserSessionController::class, 'terminateSession'])->middleware('auth', 'verified');





// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

// Coins








// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

Route::post('reports', [ReportsController::class, 'store'])
    ->name('reports.store')
    ->middleware('auth');

Route::get('reports/{contact}/edit', [ReportsController::class, 'edit'])
    ->name('reports.edit')
    ->middleware('auth');

Route::post('/reports/{contact}/send-email', [ReportsController::class, 'sendEmail'])
    ->name('reports.sendEmail')
    ->middleware('auth');

Route::post('/reports/{contact}/hire', [ReportsController::class, 'hire'])
    ->name('reports.hire')
    ->middleware('auth');

Route::post('/reports/{contact}/fire', [ReportsController::class, 'fire'])
    ->name('reports.fire')
    ->middleware('auth');

Route::post('reports/{contact}', [ReportsController::class, 'update'])
    ->name('reports.update')
    ->middleware('auth');


// Contacts


Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');



    // Privacy Policy and Terms of Service
Route::get('/privacy', function () {
    return Inertia::render('Legal/PrivacyPolicy');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('Legal/TermsOfService');
})->name('terms');
