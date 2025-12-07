<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InvitationController;

/* -------------------- AUTH ROUTES -------------------- */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.perform');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/* -------------------- PUBLIC INVITE ACCEPT -------------------- */
Route::get('/invite/accept/{token}', [InvitationController::class, 'showAcceptForm'])
    ->name('invite.accept');

Route::post('/invite/accept/{token}', [InvitationController::class, 'accept'])
    ->name('invite.accept.submit');

/* -------------------- PROTECTED ROUTES -------------------- */
Route::middleware(['auth'])->group(function () {

    /* -------------------- DASHBOARD -------------------- */
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    /* -------------------- URL SHORTENER FOR ADMIN + MEMBER -------------------- */
    Route::get('/urls', [UrlController::class, 'index'])->name('urls.index');
    Route::get('/urls/create', [UrlController::class, 'create'])->name('urls.create');
    Route::post('/urls', [UrlController::class, 'store'])->name('urls.store');

    /* -------------------- SUPERADMIN INVITES ADMIN -------------------- */
    Route::middleware('role:superadmin')->group(function () {
        Route::view('/invite-admin', 'invite-admin')->name('invite.admin');
        Route::post('/invite-admin', [InvitationController::class, 'inviteAdmin'])
            ->name('invite.admin.store');
    });

    /* -------------------- ADMIN INVITES MEMBERS -------------------- */
    Route::middleware('role:admin')->group(function () {
        Route::view('/invite-member', 'invite-member')->name('invite.member');
        Route::post('/invite-member', [InvitationController::class, 'inviteMember'])
            ->name('invite.member.store');
    });

});

/* -------------------- PUBLIC SHORT URL REDIRECT -------------------- */
Route::get('/s/{code}', [UrlController::class, 'redirect'])->name('short.redirect');

/* -------------------- DEFAULT ROUTE -------------------- */
Route::get('/', fn () => redirect()->route('dashboard'));
