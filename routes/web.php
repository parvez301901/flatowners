<?php

use App\Http\Controllers\backend\DefaultController;
use App\Http\Controllers\backend\EmployeeController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\Project_ExpenseController;
use App\Http\Controllers\backend\ProjectAddAmountController;
use App\Http\Controllers\backend\ProjectController;
use App\Http\Controllers\backend\Report;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\backend\FloorController;
use App\Http\Controllers\backend\UnitController;
use App\Http\Controllers\backend\UtilityController;
use App\Http\Controllers\backend\ServiceChargeController;
use App\Http\Controllers\backend\MaintenanceController;

/*
|---------------
| Web Routes
|---------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'Logout'])->name('admin.logout');

//full admin check
Route::group(['middleware' => 'auth'],function() {

// user management

    Route::prefix('users')->group(function () {

        Route::get('/view', [UserController::class, 'UserView'])->name('user.view');
        Route::get('/add', [UserController::class, 'UserAdd'])->name('user.add');
        Route::post('/store', [UserController::class, 'UserStore'])->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'UserEdit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'UserUpdate'])->name('user.update');
        Route::get('/detail/{id}', [UserController::class, 'UserDetail'])->name('user.detail');
        Route::post('/updateunit/{id}', [UserController::class, 'UserUnit'])->name('user.unit');

        Route::get('/assign_flat', [UserController::class, 'UserAssign'])->name('user.assign_flat');
        Route::post('/assign/store', [UserController::class, 'AssignStore'])->name('assign.store');

    });

    Route::prefix('employee')->group(function () {
        Route::get('/add', [EmployeeController::class, 'EmployeeAdd'])->name('employee.add');
        Route::post('/store', [EmployeeController::class, 'EmployeeStore'])->name('employee.store');
        Route::get('/view', [EmployeeController::class, 'EmployeeView'])->name('employee.view');
        Route::get('/detail/{id}', [EmployeeController::class, 'EmployeeDetail'])->name('employee.detail');
        Route::post('/update/{id}', [EmployeeController::class, 'EmployeeUpdate'])->name('employee.update');
    });

// User Profile and Change Password
    Route::prefix('profile')->group(function () {

        Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
    });

    Route::prefix('floor')->group(function (){
        Route::get('/view', [FloorController::class, 'FloorView'])->name('floor.view');
        Route::get('/add', [FloorController::class, 'FloorAdd'])->name('floor.add');
        Route::post('/store', [FloorController::class, 'FloorStore'])->name('floor.store');
        Route::get('/detail/{id}', [FloorController::class, 'FloorDetail'])->name('floor.detail');
        Route::post('/update/{id}', [FloorController::class, 'FloorUpdate'])->name('floor.update');
    });

    Route::prefix('unit')->group(function (){
        Route::get('/view', [UnitController::class, 'UnitView'])->name('unit.view');
        Route::get('/add', [UnitController::class, 'UnitAdd'])->name('unit.add');
        Route::post('/store', [UnitController::class, 'UnitStore'])->name('unit.store');
        Route::get('/detail/{id}', [UnitController::class, 'UnitDetail'])->name('unit.detail');
        Route::post('/update/{id}', [UnitController::class, 'UnitUpdate'])->name('unit.update');
    });

    Route::prefix('utility')->group(function (){
        Route::get('/view', [UtilityController::class, 'UtilityView'])->name('utility.view');
        Route::get('/add', [UtilityController::class, 'UtilityAdd'])->name('utility.add');
        Route::post('/store', [UtilityController::class, 'UtilityStore'])->name('utility.store');
        Route::get('/detail/{id}', [UtilityController::class, 'UtilityDetail'])->name('utility.detail');
        Route::post('/update/{id}', [UtilityController::class, 'UtilityUpdate'])->name('utility.update');
        Route::get('/delete/{id}', [UtilityController::class, 'UtilityDelete'])->name('utility.delete');
    });

    Route::prefix('servicecharge')->group( function(){
        Route::get('/search/', [ServiceChargeController::class, 'ServiceChargeSearch'])->name('servicecharge.search');
        Route::get('/view', [ServiceChargeController::class, 'ServiceChargeView'])->name('servicecharge.view');
        Route::get('/add', [ServiceChargeController::class, 'ServiceChargeAdd'])->name('servicecharge.add');
        Route::post('/store', [ServiceChargeController::class, 'ServiceChargeStore'])->name('servicecharge.store');
        //////////////------------------------------  Baki ache ------------ Edit - Update - Delete ------   /////////////////
    });

    Route::prefix('maintenance')->group( function(){
        Route::get('/add', [MaintenanceController::class, 'MaintenanceAdd'])->name('maintenance.add');
        Route::post('/store', [MaintenanceController::class, 'MaintenanceStore'])->name('maintenance.store');
        Route::get('/view', [MaintenanceController::class, 'MaintenanceView'])->name('maintenance.view');
        Route::get('/search/maintenance', [MaintenanceController::class, 'MaintenanceSearch'])->name('maintenance.search');
        //////////////------------------------------  Baki ache ------------ Edit - Update - Delete ------   /////////////////
        Route::get('/salary', [MaintenanceController::class, 'MaintenanceSalary'])->name('maintenance.salary');
        Route::get('/salary/disburse', [MaintenanceController::class, 'MaintenanceSalaryDisburse'])->name('salary.disburse');
    });

    Route::prefix('notice')->group(function (){
        Route::get('/add', [NoticeController::class, 'NoticeAdd'])->name('notice.add');
        Route::post('/store', [NoticeController::class, 'NoticeStore'])->name('notice.store');
        Route::get('/view', [NoticeController::class, 'NoticeView'])->name('notice.view');
        Route::get('/detail/{id}', [NoticeController::class, 'NoticeDetail'])->name('notice.detail');
    });

    Route::prefix('report')->group( function(){
        Route::get('/monthly/balancesheet', [Report::class, 'reportMonthlyBalancesheetView'])->name('report.monthly.balancesheet');
        Route::get('/monthly/balancesheet/search', [Report::class, 'reportMonthlyBalancesheetSearch'])->name('report.monthly.balancesheet.search');
    });

    Route::prefix('project')->group(function (){
        Route::get('/add', [ProjectController::class, 'ProjectAdd'])->name('project.add');
        Route::post('/store', [ProjectController::class, 'ProjectStore'])->name('project.store');
        Route::get('/view', [ProjectController::class, 'ProjectView'])->name('project.view');
        Route::get('/detail/{id}', [ProjectController::class, 'ProjectDetail'])->name('project.detail');
        Route::get('/balance', [ProjectController::class, 'ProjectBalance'])->name('project.balance');
        /*
        Route::post('/update/{id}', [UnitController::class, 'UnitUpdate'])->name('unit.update');
        */
    });

    Route::prefix('project_cost')->group(function (){
        Route::post('/store', [Project_ExpenseController::class, 'ProjectCostStore'])->name('project_cost.store');
        Route::get('/detail/{id}', [Project_ExpenseController::class, 'ProjectCostDetail'])->name('project_cost.detail');
        Route::post('/update/{id}', [Project_ExpenseController::class, 'ProjectCostUpdate'])->name('project_cost.update');
    });

    Route::prefix('project_deposit')->group(function (){
        Route::post('/store', [ProjectAddAmountController::class, 'ProjectAddStore'])->name('project_deposit.store');
    });

    /*Ajax actions*/
    Route::get('byfloor/getunit', [DefaultController::class, 'GetUnit'])->name('byfloor.getunit');
    Route::get('byunit/getownerid', [DefaultController::class, 'GetOwnerIdByUnit'])->name('byunit.getonwerid');

});

require __DIR__.'/auth.php';
