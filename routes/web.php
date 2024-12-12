<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProjectController;


use App\Http\Controllers\OfficialDashboardController;
use App\Http\Controllers\OfficialAuditTrailController;
use App\Http\Controllers\OfficialEventController;
use App\Http\Controllers\OfficialTransactionController;
use App\Http\Controllers\OfficialReportController;
use App\Http\Controllers\OfficialProjectController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficialActivityLogController;

//use App\Http\Controllers\CustomLoginController;

use App\Http\Controllers\SurveyLikeController;
use App\Http\Controllers\SuperAdminLoginDashboard;



use App\Http\Controller\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {

    $user = Auth::user();
// Check user type and redirect accordingly
    if ($user->user_type === 'resident') {
    return redirect()->route('dashboard'); // Redirect to resident dashboard
    } 
    else if ($user->user_type === 'admin') {
    return redirect()->route('superadmin.dashboard'); // Redirect to resident dashboard
    } 
    else {
    return redirect()->route('Official.OfficialDashboard.index'); // Redirect to official dashboard
        }
    });
});

Route::middleware(['auth'])->group(function () {
Route::get('/users', [SuperAdminLoginDashboard::class, 'listofAllUsers']);
Route::get('superadmin/dashboard', [SuperAdminLoginDashboard::class, 'index'])->name('superadmin.dashboard');
Route::get('pending-approvals', [SuperAdminLoginDashboard::class, 'listPendingApprovals'])->name('superadmin.pendingApprovals');
Route::post('/approve-user/{id}', [SuperAdminLoginDashboard::class, 'approveUser']);
Route::post('/reject-user/{id}', [SuperAdminLoginDashboard::class, 'rejectUser']);
Route::post('/change-password/{userId}', [SuperAdminLoginDashboard::class, 'changePassword'])->name('users.changePassword');

// For deleting a user
Route::post('/delete-user/{userId}', [SuperAdminLoginDashboard::class, 'deleteUser'])->name('users.delete');

Route::put('/events/{id}/status', [EventController::class, 'updateStatus']);


Route::post('/transactions',[OfficialTransactionController::class, 'store'])->name('transactions.store');


Route::get('/survey-data', [SurveyLikeController::class, 'getSurveyData']);
Route::get('/fetch-officials', [OfficialTransactionController::class, 'fetchOfficials'])->name('fetchOfficials');

Route::get('/OfficialActivityLog', [OfficialActivityLogController::class, 'index'])->name('Official.OfficialActivityLog.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resident
Route::get('/Resident/Event', [EventController::class, 'index'])->name('Resident.Event.index');
Route::get('/Resident/Project', [ProjectController::class, 'index'])->name('Resident.Project.index');

//official
//Route::post('/login', [CustomLoginController::class, 'login'])->name('login');
Route::get('/Official/OfficialDashboard', [OfficialDashboardController::class, 'index'])->name('Official.OfficialDashboard.index');
Route::get('/Official/OfficialAuditTrail', [OfficialAuditTrailController::class, 'index'])->name('Official.OfficialAuditTrail.index');
Route::get('/Official/OfficialEvent', [OfficialEventController::class, 'index'])->name('Official.OfficialEvent.index');
Route::get('/Official/OfficialTransaction', [OfficialTransactionController::class, 'index'])->name('Official.OfficialTransaction.index');
Route::get('/Official/OfficialReport', [OfficialReportController::class, 'index'])->name('Official.OfficialReport.index');
Route::get('/Official/OfficialProject', [OfficialProjectController::class, 'index'])->name('Official.OfficialProject.index');
Route::get('/Official/Edit', [EditController::class, 'index'])->name('Official.Edit.index');
Route::get('/Official/Edit2', [EditController::class, 'putangina'])->name('Official.Edit2.index');
Route::get('/generate-liquidation-report/{event}', [OfficialReportController::class, 'generateLiquidationReport'])->name('download.liquidation.report');

//Post
Route::get('/transactions/print-all', [OfficialTransactionController::class, 'printAll'])->name('transactions.printAll');
Route::get('/transactions/{transaction}/print', [OfficialTransactionController::class, 'print'])->name('transactions.print');
Route::get('/transactions/{transaction}/download', [OfficialTransactionController::class, 'downloadPDF'])->name('transactions.download');

Route::get('/liquidation-report', [OfficialReportController::class, 'showLiquidationReport'])->name('liquidation-report.liquidation.report');


Route::post('/events', [EventController::class, 'storeEvents'])->name('events.store');

// In routes/web.php
Route::post('/update-expense', [EventController::class, 'updateExpense'])->name('update.expense');


Route::get('/barangay/officials', [DashboardController::class, 'getOfficials']);


Route::put('/shit/fuckyou',[SuperAdminLoginDashboard::class, 'update'])->name('event.update');


//Route::post('/events/store', [OfficialEventController::class, 'store'])->name('events.store'); test routes ni boss pwede mani gamiton 

///event data

Route::get('/event-data', [OfficialEventController::class, 'getEvents'])->name('event.data');

//expense data
Route::get('/expenses', [OfficialEventController::class, 'getExpenses']);


Route::get('/print-event/{event}', [EventController::class, 'print'])->name('events.print');

Route::get('/events/print', [OfficialReportController::class, 'print'])->name('events.print');

// Route to handle the form submission (POST request)
Route::post('/events/print', [OfficialReportController::class, 'print'])->name('events.print.post');

Route::post('/store-like-unlike', [SurveyLikeController::class, 'storeLikeUnlike']);
Route::get('/survey-count', [SurveyLikeController::class, 'getSurveyCounts']);





Route::get('/events/load', [SuperAdminLoginDashboard::class, 'loadEvents'])->name('events.load');






Route::post('/submit-survey', [SurveyLikeController::class, 'store']);



Route::get('/survey-survey-survey',[SurveyLikeController::class, 'surveyResults'])->name('yudipota');

Route::get('/print-survey/{id}', [SurveyLikeController::class, 'print'])->name('survey.print');
Route::get('/download-survey/{id}', [SurveyLikeController::class, 'downloadPDF'])->name('survey.download');


});