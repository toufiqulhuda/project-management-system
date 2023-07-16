<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/// clear application cache
Route::get('/clear-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return "Application cache-route-view clear";
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Application cache flushed";
});

// clear route cache
Route::get('/clear-route-cache', function() {
    Artisan::call('route:clear');
    return "Route cache file removed";
});

// clear view compiled files
Route::get('/clear-view-compiled-cache', function() {
    Artisan::call('view:clear');
    return "View compiled files removed";
});

// clear config files
Route::get('/clear-config-cache', function() {
    Artisan::call('config:clear');
    return "Configuration cache file removed";
});

Route::get('/', function () {
    return redirect('home');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/* user */
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/userProfile', [App\Http\Controllers\UserController::class, 'showUserProfile'])->name('userProfile');
Route::post('/changeStatus', [App\Http\Controllers\UserController::class, 'changeUserStatus'])->name('changeStatus');
Route::get('/addUser', [App\Http\Controllers\UserController::class, 'addUserView'])->name('addUser');
Route::post('/registarUser', [App\Http\Controllers\UserController::class, 'registarUser'])->name('registarUser');
Route::get('/editUser', [App\Http\Controllers\UserController::class, 'editUserView'])->name('editUser');
Route::post('/editUser', [App\Http\Controllers\UserController::class, 'editUser'])->name('editUser');
Route::get('/changePassword',[App\Http\Controllers\UserController::class,'showChangePasswordForm']);
Route::post('/changePassword',[App\Http\Controllers\UserController::class,'changePassword'])->name('changePassword');
Route::get('/reset-user-password',[App\Http\Controllers\UserController::class,'showResetPasswordForm']);
Route::post('/reset-user-password',[App\Http\Controllers\UserController::class,'resetPassword'])->name('reset-user-password');
/*  ROLE */
Route::get('/user-role',[App\Http\Controllers\UserController::class,'showUserRoleForm'])->name('user-role');
Route::get('/add-role',[App\Http\Controllers\UserController::class,'showAddRoleForm'])->name('add-role');
Route::post('/add-role',[App\Http\Controllers\UserController::class,'saveRole']);
Route::get('/edit-role',[App\Http\Controllers\UserController::class,'showUpdateRoleForm'])->name('edit-role');
Route::post('/edit-role',[App\Http\Controllers\UserController::class,'updateRole']);
Route::post('/changeRoleStatus', [App\Http\Controllers\UserController::class, 'changeRoleStatus'])->name('changeRoleStatus');
/* project */
Route::get('/project', [App\Http\Controllers\ProjectController::class, 'index'])->name('project');
Route::get('/project-add', [App\Http\Controllers\ProjectController::class, 'add'])->name('project-add');
Route::post('/project-add', [App\Http\Controllers\ProjectController::class, 'save'])->name('project-add');
Route::get('/project-edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project-edit');
Route::post('/project-update', [App\Http\Controllers\ProjectController::class, 'update'])->name('project-update');
Route::post('/project-publish', [App\Http\Controllers\ProjectController::class, 'publish'])->name('project-publish');
Route::get('/project-details', [App\Http\Controllers\ProjectController::class, 'details'])->name('project-details');
Route::delete('attachment/{id}', [App\Http\Controllers\AttachmentController::class, 'delete'])->name('attachment.delete');
