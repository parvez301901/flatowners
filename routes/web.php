<?php

use App\Http\Controllers\backend\BankController;
use App\Http\Controllers\backend\DefaultController;
use App\Http\Controllers\backend\EmployeeController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\OtherIncomeController;
use App\Http\Controllers\backend\Project_ExpenseController;
use App\Http\Controllers\backend\ProjectAddAmountController;
use App\Http\Controllers\backend\ProjectController;
use App\Http\Controllers\backend\Report;
use App\Http\Controllers\backend\SmsSystemController;
use App\Models\backend\Project;
use App\Models\User;
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
    $data['total_flat_owner'] = User::where('usertype','flatowner')->get()->count();
    $data['total_project_running'] = Project::all()->count();
    $data['total_employee'] = User::where('usertype','employee')->get()->count();
    return view('admin.index' , $data);
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

    Route::prefix('otherincome')->group(function (){
        Route::get('/add', [OtherIncomeController::class, 'add_other_income'])->name('otherincome.add');
        Route::post('/store', [OtherIncomeController::class, 'store_other_income'])->name('otherincome.store');
        /*Route::get('/view', [UtilityController::class, 'UtilityView'])->name('utility.view');
        Route::get('/detail/{id}', [UtilityController::class, 'UtilityDetail'])->name('utility.detail');
        Route::post('/update/{id}', [UtilityController::class, 'UtilityUpdate'])->name('utility.update');
        Route::get('/delete/{id}', [UtilityController::class, 'UtilityDelete'])->name('utility.delete'); */
    });

    Route::prefix('servicecharge')->group( function(){
        Route::get('/search/', [ServiceChargeController::class, 'ServiceChargeSearch'])->name('servicecharge.search');
        Route::get('/search_by_month/', [ServiceChargeController::class, 'ServiceChargeSearchByMonth'])->name('servicecharge.search_by_month');
        Route::get('/view', [ServiceChargeController::class, 'ServiceChargeView'])->name('servicecharge.view');
        Route::get('/view_by_month', [ServiceChargeController::class, 'ServiceChargeViewByMonth'])->name('servicecharge.view_by_month');
        Route::get('/add', [ServiceChargeController::class, 'ServiceChargeAdd'])->name('servicecharge.add');
        Route::post('/store', [ServiceChargeController::class, 'ServiceChargeStore'])->name('servicecharge.store');
        Route::get('/receipt', [ServiceChargeController::class, 'ServiceChargeReceipt'])->name('servicecharge.receipt');
        Route::get('/tobank', [ServiceChargeController::class, 'ServiceChargeToBank'])->name('servicecharge.tobank');
        Route::post('/deposittobank', [ServiceChargeController::class, 'DepositToBank'])->name('servicecharge.deposittobank');
        Route::post('/withdrawfromBank', [ServiceChargeController::class, 'WithdrawFromBank'])->name('servicecharge.withdrawfrombank');
        Route::get('/dueservicecharge', [ServiceChargeController::class, 'DueServiceCharge'])->name('servicecharge.dueservicecharge');
        Route::get('/duesearch/', [ServiceChargeController::class, 'ServiceChargeDueSearch'])->name('servicecharge.dueservicechargesearch');
        Route::get('/detail/{id}', [ServiceChargeController::class, 'ServiceChargeDetail'])->name('servicecharge.detail');
        Route::post('/update/{id}', [ServiceChargeController::class, 'ServiceChargeUpdate'])->name('servicecharge.update');
    });

    Route::prefix('maintenance')->group( function(){
        Route::get('/add', [MaintenanceController::class, 'MaintenanceAdd'])->name('maintenance.add');
        Route::post('/store', [MaintenanceController::class, 'MaintenanceStore'])->name('maintenance.store');
        Route::get('/view', [MaintenanceController::class, 'MaintenanceView'])->name('maintenance.view');
        Route::get('/search/maintenance', [MaintenanceController::class, 'MaintenanceSearch'])->name('maintenance.search');
        Route::get('/detail/{id}', [MaintenanceController::class, 'MaintenanceDetail'])->name('maintenance.detail');
        Route::post('/update/{id}', [MaintenanceController::class, 'MaintenanceUpdate'])->name('maintenance.update');
        Route::get('/delete/{id}', [MaintenanceController::class, 'MaintenanceDelete'])->name('maintenance.delete');
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
        Route::get('/yearly/balancesheet', [Report::class, 'reportYearlyBalancesheetView'])->name('report.yearly.balancesheet');
        Route::get('/yearly/balancesheet/search', [Report::class, 'reportYearlyBalancesheetSearch'])->name('report.yearly.balancesheet.search');
        Route::get('/monthly/income', [Report::class, 'reportMonthlyIncome'])->name('report.monthly.income');
        Route::get('/monthly/income/search', [Report::class, 'reportMonthlyIncomeSearch'])->name('report.monthly.income.search');
    });

    Route::prefix('project')->group(function (){
        Route::get('/add', [ProjectController::class, 'ProjectAdd'])->name('project.add');
        Route::get('/add/sub_project', [ProjectController::class, 'ProjectAddSubProject'])->name('project.add_sub_project');
        Route::post('/store', [ProjectController::class, 'ProjectStore'])->name('project.store');
        Route::post('/store/sub_project', [ProjectController::class, 'ProjectStoreSubProject'])->name('project.sub_project_store');
        Route::get('/view', [ProjectController::class, 'ProjectView'])->name('project.view');
        Route::get('/detail/{id}', [ProjectController::class, 'ProjectDetail'])->name('project.detail');
        Route::get('/balance', [ProjectController::class, 'ProjectBalance'])->name('project.balance');
        Route::get('/depositmoney', [ProjectController::class, 'ProjectDepositMoney'])->name('project.depositmoney');
        Route::get('/banktransaction', [ProjectController::class, 'ProjectBankTransaction'])->name('project.banktransaction');
        Route::post('/deposittobank', [ProjectController::class, 'ProjecDepositToBank'])->name('project.deposittobank');
        Route::post('/withdrawfromBank', [ProjectController::class, 'WithdrawFromBank'])->name('project.withdrawfrombank');

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
        Route::get('sms/project_due', [ProjectAddAmountController::class, 'SMSProjectDue'])->name('project_deposit.sms');
        Route::post('/addmoneytoproject', [ProjectAddAmountController::class, 'ProjectAddMoney'])->name('project_deposit.money');
    });


    Route::prefix('sms')->group(function (){
        Route::get('/add', [SmsSystemController::class, 'SmsAdd'])->name('sms.add');
        Route::post('/send', [SmsSystemController::class, 'SmsSend'])->name('sms.send');
    });

    Route::prefix('bank')->group(function (){
        Route::get('/view', [BankController::class, 'BankView'])->name('bank.view');
        Route::get('/add', [BankController::class, 'BankAdd'])->name('bank.add');
        Route::post('/store', [BankController::class, 'BankStore'])->name('bank.store');
        Route::get('/detail/{id}', [BankController::class, 'BankDetail'])->name('bank.detail');
        Route::post('/update/{id}', [BankController::class, 'BankUpdate'])->name('bank.update');
    });

    /*Ajax actions*/
    Route::get('byfloor/getunit', [DefaultController::class, 'GetUnit'])->name('byfloor.getunit');
    Route::get('byunit/getownerid', [DefaultController::class, 'GetOwnerIdByUnit'])->name('byunit.getonwerid');
    Route::get('byunit/findownerid', [DefaultController::class, 'FindOwnerIdByUnit'])->name('byunit.findonwerid');
    Route::get('byunit/findownerid/projectdue', [DefaultController::class, 'FindDueFindOwnerIdByUnit'])->name('byunit.findonwerid.project_due');
    Route::get('sms/smsthankyou', [DefaultController::class, 'SMSThankYou'])->name('sms.thankyou');
    Route::get('sms/due_remind', [DefaultController::class, 'SMSDueRemind'])->name('sms.due_remind');
    Route::get('pettybalance', [DefaultController::class, 'PettyBalanceCheck'])->name('petty.balance');
    Route::get('bybankid/findbankinfo', [DefaultController::class, 'ByBankIdFindBankInfo'])->name('bybankid.findbankinfo');

});

require __DIR__.'/auth.php';
