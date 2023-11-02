<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'verified', 'admin'],
],function(){

    Route::resource('/trainings', \App\Http\Controllers\Admin\TrainingController::class);
    

});


// Route::resource('/training-registration', \App\Http\Controllers\TrainingRegistrationController::class);

Route::resource('/training-registration', \App\Http\Controllers\TrainingRegistrationController::class)->parameters([
    'training-registration' => 'id'
])->except(['index']);

// By using parameters(['training-registration' => 'id']), you're customizing this default behavior so that, instead of training_registration, the parameter name will be id. So, your show, edit, update, and destroy methods in the controller would expect a parameter named $id instead of $training_registration.

// Route::resource('/training-registration', \App\Http\Controllers\TrainingRegistrationController::class)->except(['index']);

Route::get('/training-registration/{id}', [\App\Http\Controllers\TrainingRegistrationController::class, 'index'])->name('training-registration.index');


Route::get('/training-list', [\App\Http\Controllers\TrainingListController::class, 'index'])->name('training-list.index');

Route::get('/training-dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('training-dashboard.index');

Route::get('/manage-registration', [\App\Http\Controllers\Admin\ManageRegistrationController::class, 'index'])->name('manage-registration.index');

Route::patch('/manage-registrations/update-status/{id}', [\App\Http\Controllers\Admin\ManageRegistrationController::class, 'updateStatus'])->name('manage-registration.update_status');


require __DIR__.'/auth.php';
