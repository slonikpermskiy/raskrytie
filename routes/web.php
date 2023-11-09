<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MainpageController;

use App\Notifications\SendPlan;


/*Route::get('/', function () {
    return view('welcome');
})->name('welcome');*/

Route::get('/', function () {
    return redirect('/main');
});

Route::get('/main/{vue_capture?}', function () {
	return view('welcome');
})->where('vue_capture', '[\/\w\.-]*')->name('welcome');


Route::get('/getmaincalendarotchets',[MainpageController::class, 'getMainCalendarOtchets'])->name('getmaincalendarotchets');
Route::get('/getstandartcategorieslist',[MainpageController::class, 'getStandartCategoriesList'])->name('getstandartcategorieslist');
Route::get('/getstandartotchetslist',[MainpageController::class, 'getStandartOtchetsList'])->name('getstandartotchetslist');



Route::middleware(['auth', 'verified', 'revalidate'])->group(function () {
	
	
	Route::get('/lk/standartcategorieslist',[UserController::class, 'standartCategoriesList'])->name('standartcategorieslist');
	
	Route::get('/lk/usercategorieslist',[UserController::class, 'userCategoriesList'])->name('usercategorieslist');

	Route::get('/lk/allcategorieslist',[UserController::class, 'allCategoriesList'])->name('allcategorieslist');
	
	Route::post('/lk/newusercategory',[UserController::class, 'newUserCategory'])->name('newusercategory');
	
	Route::post('/lk/deleteusercategory',[UserController::class, 'deleteUserCategory'])->name('deleteusercategory');
	
	Route::get('/lk/standartotchetslist',[UserController::class, 'standartOtchetsList'])->name('standartotchetslist');
	
	Route::get('/lk/userotchetslist',[UserController::class, 'userOtchetsList'])->name('userotchetslist');
	
	Route::post('/lk/newuserotchet',[UserController::class, 'newUserOtchet'])->name('newuserotchet');
	
	Route::post('/lk/deleteuserotchet',[UserController::class, 'deleteUserOtchet'])->name('deleteuserotchet');
	
	Route::post('/lk/settootchetplan',[UserController::class, 'setToOtchetPlan'])->name('settootchetplan');
	
	Route::post('/lk/deletetootchetplan',[UserController::class, 'deleteToOtchetPlan'])->name('deletetootchetplan');
	
	Route::post('/lk/getfreepremium',[UserController::class, 'getFreePremium'])->name('getfreepremium');
	
	Route::get('/lk/oneuserdata',[UserController::class, 'oneUserData'])->name('oneuserdata');
	
	Route::post('/lk/changeuserdata',[UserController::class, 'changeUserData'])->name('changeuserdata');
	
	Route::post('/lk/changeuserpassword',[UserController::class, 'changeUserPassword'])->name('changeuserpassword');
	
	Route::get('/lk/getuser',[UserController::class, 'getUser'])->name('getuser');
	
	Route::post('/lk/sendbill',[UserController::class, 'sendBill'])->name('sendbill');

	Route::post('/lk/sendplan',[UserController::class, 'sendPlan'])->name('sendplan');
	
	Route::get('/lk/getcalendarotchets',[UserController::class, 'getCalendarOtchets'])->name('getcalendarotchets');
	
	Route::get('/lk/getcalendarotchetscount',[UserController::class, 'getCalendarOtchetsCount'])->name('getcalendarotchetscount');
	
	Route::post('/lk/setotchetstatus',[UserController::class, 'setOtchetStatus'])->name('setotchetstatus');
	
	Route::post('/lk/deleteotchetstatistic',[UserController::class, 'deleteOtchetStatistic'])->name('deleteotchetstatistic');
	
	Route::get('/lk/planedstandartcategorieslist',[UserController::class, 'planedStandartCategoriesList'])->name('planedstandartcategorieslist');
	
	Route::get('/lk/planedusercategorieslist',[UserController::class, 'planedUserCategoriesList'])->name('planedusercategorieslist');
	
	Route::get('/lk/planedstandartotchetslist',[UserController::class, 'planedStandartOtchetsList'])->name('planedplanedstandartotchetslist');
	
	Route::get('/lk/planeduserotchetslist',[UserController::class, 'planedUserOtchetsList'])->name('planeduserotchetslist');
	
	Route::get('/lk/planedstandartotchetslist',[UserController::class, 'planedStandartOtchetsList'])->name('planedstandartotchetslist');
	
	Route::get('/lk/planeduserotchetslist',[UserController::class, 'planedUserOtchetsList'])->name('planeduserotchetslist');
	
	Route::get('/lk/getplanfactdates',[UserController::class, 'getPlanFactDates'])->name('getplanfactdates');
	
	Route::get('/lk/{vue_capture?}', function () {
		return view('lk');
	})->where('vue_capture', '[\/\w\.-]*')->name('lk');
	

});



//Auth::routes();
//require __DIR__.'/auth.php';


// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout',  [LoginController::class,'logout'])->name('logout');

// Registration Routes...
//Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
//Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Confirm Password (added in v6.2)
//Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
//Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

// Email Verification Routes...
//Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//Route::get('email/resend',  [VerificationController::class, 'resend'])->name('verification.resend');


Route::get('/email/verify', function () {
	if (Auth::user()->hasVerifiedEmail()) {
		return redirect('/lk');
	} else {
		return view('auth.verify-email');
	}	
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/lk');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Ссылка была отправлена!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



/*Route::prefix('lk')->middleware(['auth'])->name('lk.')->group(function () {
    Route::get('/', [PagesController::class, 'index'])->name('entry');
    Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
	Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::get('/',[LkController::class, 'index'])->name('lk');
	Route::get('/calendar',[LkController::class, 'calendar'])->name('calendar');
	Route::get('/laws',[LkController::class, 'laws'])->name('laws');
 });*/


