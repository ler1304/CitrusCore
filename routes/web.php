<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScmModuleController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard/admin');

Route::get('/batch-baru', [DashboardController::class, 'batchBaru'])->name('batch.baru');
Route::post('/batch-baru', [DashboardController::class, 'batchBaruStore'])->name('batch.baru.store');

Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');
Route::post('/pengaturan', [DashboardController::class, 'pengaturanUpdate'])->name('pengaturan.update');

Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');
Route::get('/bantuan', [DashboardController::class, 'bantuan'])->name('bantuan');

Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/admin/export', [DashboardController::class, 'adminExport'])->name('dashboard.admin.export');

Route::get('/dashboard/pedagang', [DashboardController::class, 'pedagang'])->name('dashboard.pedagang');
Route::post('/dashboard/pedagang/publish-harga', [DashboardController::class, 'publishHarga'])->name('dashboard.pedagang.publish-harga');
Route::post('/dashboard/pedagang/kontrak/{id}/status', [DashboardController::class, 'updateStatusKontrak'])->name('dashboard.pedagang.kontrak.status');
Route::post('/dashboard/pedagang/kontrak/{id}/renegosiasi', [DashboardController::class, 'renegosiasiKontrak'])->name('dashboard.pedagang.kontrak.renegosiasi');

Route::get('/dashboard/logistik', [DashboardController::class, 'logistik'])->name('dashboard.logistik');
Route::post('/dashboard/logistik/transaksi/{id}', [DashboardController::class, 'updateLogistik'])->name('dashboard.logistik.transaksi.update');

Route::get('/kontrak/{id}', [DashboardController::class, 'kontrakDetail'])->name('kontrak.show');
Route::post('/kontrak/{id}/status', [DashboardController::class, 'kontrakUpdateStatus'])->name('kontrak.status.update');

Route::get('/modul/demand', [ScmModuleController::class, 'demandIndex'])->name('modules.demand.index');
Route::post('/modul/demand', [ScmModuleController::class, 'demandStore'])->name('modules.demand.store');
Route::post('/modul/demand/{id}/update', [ScmModuleController::class, 'demandUpdate'])->name('modules.demand.update');
Route::post('/modul/demand/{id}/delete', [ScmModuleController::class, 'demandDelete'])->name('modules.demand.delete');

Route::get('/modul/agro', [ScmModuleController::class, 'agroIndex'])->name('modules.agro.index');
Route::post('/modul/agro', [ScmModuleController::class, 'agroStore'])->name('modules.agro.store');
Route::post('/modul/agro/{id}/status', [ScmModuleController::class, 'agroUpdateStatus'])->name('modules.agro.status');
Route::post('/modul/agro/{id}/update', [ScmModuleController::class, 'agroUpdate'])->name('modules.agro.update');
Route::post('/modul/agro/{id}/delete', [ScmModuleController::class, 'agroDelete'])->name('modules.agro.delete');

Route::get('/modul/marketplace', [ScmModuleController::class, 'marketplaceIndex'])->name('modules.marketplace.index');
Route::post('/modul/marketplace/{id}/status', [ScmModuleController::class, 'marketplaceUpdateStatus'])->name('modules.marketplace.status');
Route::post('/modul/marketplace/{id}/update', [ScmModuleController::class, 'marketplaceUpdate'])->name('modules.marketplace.update');
Route::post('/modul/marketplace/{id}/delete', [ScmModuleController::class, 'marketplaceDelete'])->name('modules.marketplace.delete');

Route::get('/modul/komunikasi', [ScmModuleController::class, 'komunikasiIndex'])->name('modules.komunikasi.index');
Route::post('/modul/komunikasi', [ScmModuleController::class, 'komunikasiStore'])->name('modules.komunikasi.store');
Route::post('/modul/komunikasi/{id}/update', [ScmModuleController::class, 'komunikasiUpdate'])->name('modules.komunikasi.update');
Route::post('/modul/komunikasi/{id}/delete', [ScmModuleController::class, 'komunikasiDelete'])->name('modules.komunikasi.delete');

Route::get('/modul/kontrak', [ScmModuleController::class, 'kontrakIndex'])->name('modules.kontrak.index');
Route::post('/modul/kontrak', [ScmModuleController::class, 'kontrakStore'])->name('modules.kontrak.store');
Route::post('/modul/kontrak/{id}/update', [ScmModuleController::class, 'kontrakUpdate'])->name('modules.kontrak.update');
Route::post('/modul/kontrak/{id}/status', [ScmModuleController::class, 'kontrakUpdateStatus'])->name('modules.kontrak.status');
Route::post('/modul/kontrak/{id}/delete', [ScmModuleController::class, 'kontrakDelete'])->name('modules.kontrak.delete');
