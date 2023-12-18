<?php

use Illuminate\Support\Facades\Route;


Route::post('/user/create', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'store'])->name('user.create');
Route::get('/user/list', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/list/{id}', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'show'])->name('user.show');
Route::put('/user/update/{id}', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::put('/user/update/all/permissions', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'updatePermissions'])->name('user.updatePermissions');
Route::post('/user/avatar/update/{id}', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'updateAvatar'])->name('user.updateAvatar');
Route::get('/user/rooms/list/{id}', [\Idsign\Kaleyra\Http\Controllers\UserController::class, 'userRooms'])->name('user.userRooms');

//rooms
Route::post('/room/create', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
Route::get('/room/list', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
Route::get('/room/info/{id}', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'show'])->name('rooms.show');
//Route::put('/room/disable/{id}', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'disable'])->name('rooms.disable');
Route::get('/room/{id}/upload/list', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'uploads'])->name('rooms.uploads');
Route::get('/room/{id}/envelope/list', [\Idsign\Kaleyra\Http\Controllers\RoomController::class, 'envelopes'])->name('rooms.envelopes');

//company
Route::get('/company', [\Idsign\Kaleyra\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
Route::post('/company/update', [\Idsign\Kaleyra\Http\Controllers\CompanyController::class, 'update'])->name('company.update');
Route::post('/company/logo/update', [\Idsign\Kaleyra\Http\Controllers\CompanyController::class, 'logoUpdate'])->name('company.logoUpdate');
Route::post('/company/virtual-background', [\Idsign\Kaleyra\Http\Controllers\CompanyController::class, 'backgroundUpdate'])->name('company.backgroundUpdate');
