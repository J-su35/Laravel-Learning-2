<?php

use Illuminate\Support\Facades\Route;
// use App\Models\User; //Eloquent method
use Illuminate\Support\Facades\DB; //Query Builder method
use App\Http\Controllers\departmentController;
use App\Models\department;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // Data from model user, Eloquent method
        // $users=User::all();
        // Query Builder method
        $users = DB::table('users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');

    Route::get('/department/all',[departmentController::class,'index'])->name('department');
    Route::post('/department/add',[departmentController::class,'store'])->name('addDepartment');
    Route::get('/department/edit/{id}',[departmentController::class,'edit']);
    Route::post('/department/update/{id}',[departmentController::class,'update']);
    Route::get('/department/softdelete/{id}',[departmentController::class,'softdelete']);
    Route::get('/department/restore/{id}',[departmentController::class,'restore']);
    Route::get('/department/delete/{id}',[departmentController::class,'delete']);

    //Service
    Route::get('/service/all',[ServiceController::class,'index'])->name('services');
    Route::post('/service/add',[ServiceController::class,'store'])->name('addService');
    Route::get('/service/edit/{id}',[ServiceController::class,'edit']);
    Route::get('/service/delete/{id}',[ServiceController::class,'delete']);
    Route::post('/service/update/{id}',[ServiceController::class,'update']);
});

