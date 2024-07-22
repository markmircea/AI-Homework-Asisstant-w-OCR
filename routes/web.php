<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
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



// Google OCR

Route::post('/ocr', [OCRMController::class, 'store'])
    ->name('ocr.store')
    ->middleware('auth');




// Google OAuth routes
Route::get('/login/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('login.google');

Route::get('/login/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);


// Route for authenticated users
Route::get('/index', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Route for non-authenticated users
Route::get('/index-no-auth', [DashboardController::class, 'indexNoAuth'])
    ->middleware('guest')
    ->name('indexNoAuth');

// Redirect root to non-authenticated route if user is not authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('indexNoAuth');
    }
});


// Announcement

Route::middleware('auth')->group(function () {
    Route::resource('announcements', AnnouncementController::class)->except(['show', 'index']);
});

Route::post('/announcements/update-order', [AnnouncementController::class, 'updateOrder'])
    ->name('updateOrder')
    ->middleware('auth');



// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
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


// History

Route::middleware('auth')->group(function () {
    Route::get('history', [HistoryController::class, 'index'])->name('history');
    Route::get('history/{announcement}/edit', [HistoryController::class, 'edit'])->name('history.edit');
    Route::put('history/{announcement}', [HistoryController::class, 'update'])->name('history.update');
    Route::delete('history/{announcement}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::post('history/update-order', [HistoryController::class, 'updateOrder'])->name('history.updateOrder');
});



Route::post('/history/{id}/send-email', [HistoryController::class, 'sendEmail'])
    ->name('history.sendEmail')
    ->middleware('auth');










// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

// Coins
