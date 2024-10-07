<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\Sys\MenuController;
use App\Http\Controllers\Sys\RoleController;
use App\Http\Controllers\Usr\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sys\SettingController;
use App\Http\Controllers\Sys\PermissionController;
use App\Http\Controllers\Trainer\TrainerController;
use App\Http\Controllers\Training\TrainingController;
use App\Http\Controllers\Attendance\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('/');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/register-account', [LoginController::class, 'registerAccount'])->name('register-account');
Route::post('/register-store', [LoginController::class, 'registerStore'])->name('register-store'); 
Route::get('/usernamechecking/{val}', [LoginController::class, 'usernamechecking']);
Route::get('/emailchecking/{val}', [LoginController::class, 'emailchecking']);
Route::get('/verification/{token}', [LoginController::class, 'verification'])->name('/verification');

Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

Route::get('setting/edit', [SettingController::class, 'edit'])->name('setting/edit');
Route::post('setting/update', [SettingController::class, 'update'])->name('setting/update');
Route::get('setting/training-type', [SettingController::class, 'trainingType'])->name('setting/training-type'); 
Route::get('setting/create-training', [SettingController::class, 'createTraining'])->name('setting/create-training'); 
Route::post('setting/store-training', [SettingController::class, 'storeTraining'])->name('setting/store-training');
Route::get('setting/edit-training/{id}', [SettingController::class, 'editTraining'])->name('setting/edit-training');
Route::post('setting/update-training', [SettingController::class, 'updateTraining'])->name('setting/update-training');
Route::get('setting/view-training', [SettingController::class, 'viewTraining'])->name('setting/view-training'); 
Route::post('setting/delete-training/{id}/', [SettingController::class, 'deleteTraining'])->name('setting/delete-training');

Route::get('error/log/{id}', [ErrorController::class, 'log'])->name('error/log');
Route::get('error/store/{id}/{url}/{error}', [ErrorController::class, 'store'])->name('error/store');

Route::get('permissions/index', [PermissionController::class, 'index'])->name('permissions/index');
Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions/create');
Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions/store'); 
Route::get('permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions/edit'); 
Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions/update'); 
Route::post('permissions/delete/{id}/', [PermissionController::class, 'delete'])->name('permissions/delete'); 

Route::get('roles/index', [RoleController::class, 'index'])->name('roles/index');
Route::get('roles/create', [RoleController::class, 'create'])->name('roles/create');
Route::post('roles/store', [RoleController::class, 'store'])->name('roles/store'); 
Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles/edit');
Route::post('roles/update', [RoleController::class, 'update'])->name('roles/update'); 
Route::post('roles/delete/{id}', [RoleController::class, 'delete'])->name('roles/delete'); 

Route::get('menu/index', [MenuController::class, 'index'])->name('menu/index');
Route::get('menu/create', [MenuController::class, 'create'])->name('menu/create');
Route::post('menu/store', [MenuController::class, 'store'])->name('menu/store'); 
Route::get('menu/edit-parent/{id}', [MenuController::class, 'editparent'])->name('menu/edit-parent');
Route::get('menu/edit-child1/{id}', [MenuController::class, 'editchild1'])->name('menu/edit-child1');
Route::get('menu/edit-child2/{id}', [MenuController::class, 'editchild2'])->name('menu/edit-child2');
Route::post('menu/update', [MenuController::class, 'update'])->name('menu/update'); 
Route::get('menu/delete-parent/{id}', [MenuController::class, 'deleteparent'])->name('menu/delete-parent');
Route::get('menu/delete-child1/{id}', [MenuController::class, 'deletechild1'])->name('menu/delete-child1');
Route::get('menu/delete-child2/{id}', [MenuController::class, 'deletechild2'])->name('menu/delete-child2');

Route::get('users/index', [UserController::class, 'index'])->name('users/index');
Route::get('users/create', [UserController::class, 'create'])->name('users/create');
Route::post('users/store', [UserController::class, 'store'])->name('users/store'); 
Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users/edit');
Route::post('users/update', [UserController::class, 'update'])->name('users/update'); 
Route::get('users/view/{id}', [UserController::class, 'view'])->name('users/view');
Route::post('users/delete/{id}', [UserController::class, 'delete'])->name('users/delete'); 
Route::get('users/namechecking/{val}', [UserController::class, 'namechecking']);
Route::get('users/usernamechecking/{val}', [UserController::class, 'usernamechecking']);
Route::get('users/emailchecking/{id}/{val}', [UserController::class, 'emailchecking']);
Route::get('users/identificationcardchecking/{id}/{val}', [UserController::class, 'identificationcardchecking']);
Route::get('users/read-notification/{id}', [UserController::class, 'readNotification'])->name('users/read-notification');
Route::get('users/list-notification', [UserController::class, 'listNotification'])->name('users/list-notification');
Route::get('users/list', [UserController::class, 'list'])->name('users/list');
Route::get('user/complete-details/{id}', [UserController::class, 'complete'])->name('user/complete-details');
Route::post('users/complete-update', [UserController::class, 'completeUpdate'])->name('users/complete-update'); 

Route::get('trainers/index', [TrainerController::class, 'index'])->name('trainers/index');
Route::get('trainers/create', [TrainerController::class, 'create'])->name('trainers/create');
Route::post('trainers/store', [TrainerController::class, 'store'])->name('trainers/store'); 
Route::get('trainers/emailchecking/{id}/{val}', [TrainerController::class, 'emailchecking']);
Route::get('trainers/identificationcardchecking/{id}/{val}', [TrainerController::class, 'identificationcardchecking']);
Route::get('trainers/view/{id}', [TrainerController::class, 'view'])->name('trainers/view');
Route::get('trainers/edit/{id}', [TrainerController::class, 'edit'])->name('trainers/edit');
Route::post('trainers/update', [TrainerController::class, 'update'])->name('trainers/update');
Route::post('trainers/delete/{id}', [TrainerController::class, 'delete'])->name('trainers/delete'); 

Route::get('trainings/index', [TrainingController::class, 'index'])->name('trainings/index');
Route::get('trainings/create', [TrainingController::class, 'create'])->name('trainings/create');
Route::post('trainings/store', [TrainingController::class, 'store'])->name('trainings/store'); 
Route::get('trainings/view/{id}', [TrainingController::class, 'view'])->name('trainings/view');
Route::get('trainings/edit/{id}', [TrainingController::class, 'edit'])->name('trainings/edit');
Route::post('trainings/update', [TrainingController::class, 'update'])->name('trainings/update');
Route::post('trainings/delete/{id}', [TrainingController::class, 'delete'])->name('trainings/delete'); 

Route::get('attendance/form/{training_id}/{trainer_id}', [AttendanceController::class, 'form'])->name('attendance/form');
Route::get('attendance/registered', [AttendanceController::class, 'thanks'])->name('attendance/registered');
Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance/store'); 
Route::get('attendance/list-attendance/{id}', [AttendanceController::class, 'listAttendance'])->name('attendance/list-attendance');
Route::get('attendance/generate-certificate/{training_id}/{attendance_id}', [AttendanceController::class, 'generateCertificate'])->name('attendance.generateCertificate');
Route::get('certificates/bulk/{trainingId}', [AttendanceController::class, 'bulkGenerateCertificates'])->name('certificates.bulk');
Route::get('/attendance/pdf/{trainingId}', [AttendanceController::class, 'printAttendancePDF'])->name('attendance.printPDF');