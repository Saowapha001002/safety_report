<?php

use App\Http\Controllers\ApproveController;
use App\Http\Controllers\ApproveLoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Back\EventController;
use App\Http\Controllers\Back\RankController;
use App\Http\Controllers\Back\CauseController;
use App\Http\Controllers\Back\CheckMagicFingerController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\Front\FromController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SheapproveController;
use App\Http\Controllers\Back\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================= Secure JS (ต้อง login) =======================
Route::group(['middleware' => ['auth']], function () {
    Route::get('/secure-js/{filename}', function (Request $request, $filename) {
        $path = storage_path("app/private/{$filename}");

        if (!file_exists($path)) {
            abort(404);
        }

        if (!$request->hasValidSignature()) {
            abort(403, "Unauthorized Access");
        }

        return response()->file($path, [
            'Content-Type'  => 'application/javascript',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    })->where('filename', '.*')->name('secure.js');
});

// ======================= Auth =======================
Route::get('/',        [AuthController::class, 'index'])->name('login');
Route::get('/login',   [AuthController::class, 'index'])->name('login');
Route::post('/login',  [AuthController::class, 'login']);
Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register');
Route::post('/CheckEmpID', [AuthController::class, 'CheckEmpID'])->name('CheckEmpID');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');

// ======================= Magic link (ไม่ต้อง login) =======================
// ผู้จัดการฝ่ายกดจากเมล -> showByToken ใน ApproveController
Route::get('/approve/login', [ApproveLoginController::class, 'showByToken'])->name('approve.magic.login');

// SHE / Manager auto-login ผ่าน ApproveLoginController (ถ้ายังใช้)
Route::get('/sheapprove/login/{token}', [ApproveLoginController::class, 'sheLoginWithToken'])
    ->name('sheapprove.magic.login');

Route::get('/manager/login/{token}', [ApproveLoginController::class, 'managerLoginWithToken'])
    ->name('manager.magic.login');

// ======================= ส่วนที่ต้อง login ทั้งหมด =======================

Route::group(['middleware' => ['auth']], function () {

    // หน้า dashboard หลัก
    Route::resource('main', MainController::class);

    // ===== ผู้จัดการฝ่าย Approve =====
    Route::get('/approve',                [ApproveController::class, 'index'])->name('approve.index');
    Route::get('/approve/view/{id}',      [ApproveController::class, 'show'])->name('approve.page');
    Route::post('/approve/confirm/{id}',  [ApproveController::class, 'confirm'])->name('approve.confirm');
    Route::post('/approve/save',          [ApproveController::class, 'store'])->name('approve.store');
    

    // ===== Form แจ้งเหตุ Magic Finger (พนักงานกรอก) =====
    Route::get('/from',        [FromController::class, 'index'])->name('magic');
    Route::post('/from/save',  [FromController::class, 'store'])->name('from.store');
    Route::get('/from/success',[FromController::class, 'success'])->name('from.success');

    // ===== Manager Follow-up =====
    Route::get('/manager',              [ManagerController::class, 'index'])->name('manager.index');
    Route::get('/manager/view/{id}',    [ManagerController::class, 'show'])->name('manager.page');
    Route::post('/manager/confirm/{id}',[ManagerController::class, 'confirm'])->name('manager.confirm');
    Route::post('/manager/update',      [ManagerController::class, 'update'])->name('manager.update');

    // ===== SHE Approve =====
    Route::get('/sheapprove',               [SheapproveController::class, 'index'])->name('sheapprove.index');
    Route::get('/sheapprove/view/{id}',     [SheapproveController::class, 'show'])->name('sheapprove.page');
    Route::post('/sheapprove/confirm/{id}', [SheapproveController::class, 'confirm'])->name('sheapprove.confirm');
    Route::post('/sheapprove/update',       [SheapproveController::class, 'update'])->name('sheapprove.update');

    // ===== Backend : Check Magic Finger =====
    Route::get('/checkmagicfinger',      [CheckMagicFingerController::class, 'index'])->name('checkmagicfinger');
    Route::get('/checkmagicfinger/list', [CheckMagicFingerController::class, 'index'])->name('checkmagicfinger/list');
    Route::get('/checkmagicfinger/edit/{id}', [CheckMagicFingerController::class, 'edit'])->name('checkmagicfinger.page');
    // เพิ่ม Route สำหรับบันทึกข้อมูล
    Route::post('/checkmagicfinger/update/{id}', [CheckMagicFingerController::class, 'update'])->name('checkmagicfinger.update');

    // ===== Master Data : Rank =====
    Route::get('/rank',            [RankController::class, 'index'])->name('rank.index');
    Route::get('/rank/create',     [RankController::class, 'create'])->name('rank.create');
    Route::post('/rank/store',     [RankController::class, 'store'])->name('rank.store');
    Route::get('/rank/edit/{id}',  [RankController::class, 'edit'])->name('rank.edit');
    Route::put('/rank/update/{id}',[RankController::class, 'update'])->name('rank.update');
    Route::get('/rank/list',       [RankController::class, 'list'])->name('rank/list');

    // ===== Master Data : Event =====
    Route::get('/event',            [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create',     [EventController::class, 'create'])->name('event.create');
    Route::post('/event/store',     [EventController::class, 'store'])->name('event.store');
    Route::get('/event/edit/{id}',  [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/update/{id}',[EventController::class, 'update'])->name('event.update');
    Route::get('/event/list',       [EventController::class, 'list'])->name('event/list');

    // ===== Master Data : Cause =====
    Route::get('/cause',            [CauseController::class, 'index'])->name('cause.index');
    Route::get('/cause/create',     [CauseController::class, 'create'])->name('cause.create');
    Route::post('/cause/store',     [CauseController::class, 'store'])->name('cause.store');
    Route::get('/cause/edit/{id}',  [CauseController::class, 'edit'])->name('cause.edit');
    Route::put('/cause/update/{id}',[CauseController::class, 'update'])->name('cause.update');
    Route::get('/cause/list',       [CauseController::class, 'list'])->name('cause/list');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/export', [DashboardController::class, 'exportCsv'])->name('dashboard.index.export');

});
