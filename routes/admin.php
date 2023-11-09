<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;


Route::get('/login',[AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('adminLogout');


Route::middleware(['adminauth'])->group(function () {
	
	//Route::get('/',[AdminController::class, 'adminmainpage'])->name('admin');
	
	Route::get('/userslist',[AdminController::class, 'usersList'])->name('userslist');
	
	Route::post('/changeuserdata',[AdminController::class, 'changeUser'])->name('changeUser');
	
	Route::post('/changeuserpassword',[AdminController::class, 'changeUserPassword'])->name('changeUserPassword');
	
	Route::post('/deleteuser',[AdminController::class, 'deleteUser'])->name('deleteUser');
	
	Route::post('/newcategory',[AdminController::class, 'newCategory'])->name('newCategory');
		
	Route::get('/categorieslist',[AdminController::class, 'categoriesList'])->name('categorieslist');
	
	Route::post('/deletecategory',[AdminController::class, 'deleteCategory'])->name('deleteCategory');
	
	Route::post('/newotchet',[AdminController::class, 'newOtchet'])->name('newOtchet');
	
	Route::get('/otchetslist',[AdminController::class, 'otchetsList'])->name('otchetslist');
	
	Route::post('/deleteotchet',[AdminController::class, 'deleteOtchet'])->name('deleteOtchet');
	
	Route::post('/admindeleteotchetstatistic',[AdminController::class, 'adminDeleteOtchetStatistic'])->name('admindeleteotchetstatistic');
	
	
	Route::get('/{vue_capture?}', function () {
		return view('admin.adminmainpage');
	})->where('vue_capture', '[\/\w\.-]*')->name('admin');
	
	
});


