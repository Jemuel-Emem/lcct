<?php
use App\Http\Controllers\AuthController;
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

Route::view('/', 'welcome');


Route::middleware([

    ])->group(function () {
         Route::get('/dashboard', function () {
           if (auth()->user()->is_admin == 1) {
            return redirect()->route('Admindashboard');
           }
           elseif(auth()->user()->is_admin == 2) {
            return redirect()->route('Doctordashboard');
           }
           elseif(auth()->user()->is_admin == 3) {
            return redirect()->route('Staffdashboard');
           }
           else{
            return redirect()->route('Patientdashboard');
           }
         })->name('dashboard');

    });

    Route::prefix('admin')->middleware('admin')->group(function(){
        Route::get('/Admindashboard', function(){
            return view('admin.index');
        })->name('Admindashboard');

        Route::get('/admin.add-patient', function(){
            return view('admin.add-patient');
        })->name('admin.add-patient');

        Route::get('/admin.add-treatment', function(){
            return view('admin.add-treatment');
        })->name('admin.add-treatment');

        Route::get('/admin.add-medicine', function(){
            return view('admin.add-medicine');
        })->name('admin.add-medicine');

        Route::get('/admin.prescription', function(){
            return view('admin.prescription');
        })->name('admin.prescription');

        Route::get('/admin.user', function(){
            return view('admin.user');
        })->name('admin.user');

        Route::get('/admin.student', function(){
            return view('admin.students');
        })->name('admin.student');



     });

     Route::prefix('patient')->middleware('patient')->group(function(){
        Route::get('/dashboard', function(){
               return view('patient.index');
           })->name('Patientdashboard');



    });

    Route::prefix('doctor')->middleware('doctor')->group(function(){
        Route::get('/dashboard', function(){
               return view('doctor.index');
           })->name('Doctordashboard');



    });

    Route::prefix('staff')->middleware('staff')->group(function(){
        Route::get('/dashboard', function(){
               return view('staff.index');
           })->name('Staffdashboard');

           Route::get('/staff.medicine', function(){
            return view('staff.medecine');
        })->name('staff.medicine');

        Route::get('/staff.treatments', function(){
            return view('staff.treatment');
        })->name('staff.treatments');

        Route::get('/staff.patient', function(){
            return view('staff.patient');
        })->name('staff.patient');


        Route::get('/staff.add-student', function(){
            return view('staff.add-student');
        })->name('staff.add-student');

        Route::get('/staff.prescriptions', function(){
            return view('staff.prescriptions');
        })->name('staff.prescriptions');

        Route::get('/staff.medical', function(){
            return view('staff.medical');
        })->name('staff.medical');

        Route::get('/staff.dental', function(){
            return view('staff.dental');
        })->name('staff.dental');


    });





Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
require __DIR__.'/auth.php';
