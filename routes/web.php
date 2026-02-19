<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SiswaExamController;
use App\Http\Controllers\Guru\ResultController;
use App\Exports\ExamResultsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Middleware\CheckGuru;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function (Request $request) {
    $role = $request->query('role');

    return match ($role) {
        'guru'  => redirect()->route('login.guru'),
        'siswa' => redirect()->route('login.siswa'),
        default => redirect()->route('login.guru'),
    };
})->name('login');


Route::get('/login/siswa', [AuthenticatedSessionController::class, 'createSiswa'])
    ->name('login.siswa');

Route::post('/login/siswa', [AuthenticatedSessionController::class, 'storeSiswa'])
    ->name('login.siswa.post');

Route::get('/login/guru', [AuthenticatedSessionController::class, 'createGuru'])
    ->name('login.guru');

Route::post('/login/guru', [AuthenticatedSessionController::class, 'storeGuru'])
    ->name('login.guru.post');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/register/siswa', [RegisteredUserController::class, 'createSiswa'])
    ->name('register.siswa');

Route::post('/register/siswa', [RegisteredUserController::class, 'storeSiswa'])
    ->name('register.siswa.post');


Route::middleware(['auth', CheckGuru::class])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {


        Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
        Route::get('exams/create', [ExamController::class, 'create'])->name('exams.create');
        Route::post('exams', [ExamController::class, 'store'])->name('exams.store');

        Route::get('exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
        Route::put('exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
        Route::delete('exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');

        Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');
        Route::get('exams/{exam}/{student}/result', [ExamController::class, 'showStudentResult'])->name('exams.studentResult');

        Route::get('exams/results', [ExamController::class, 'allResults'])
    ->name('exams.results.all');

    Route::get('exams/results', [ExamController::class, 'resultsPage'])
    ->name('exams.results.page');



        Route::prefix('exams/{exam}/questions')->name('questions.')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])->name('index');
            Route::get('/create', [QuestionController::class, 'create'])->name('create');
            Route::post('/', [QuestionController::class, 'store'])->name('store');
            Route::get('{question}/edit', [QuestionController::class, 'edit'])->name('edit');
            Route::put('{question}', [QuestionController::class, 'update'])->name('update');
            Route::delete('{question}', [QuestionController::class, 'destroy'])->name('destroy');
        });

        Route::post('exams/{exam}/activate',
    [ExamController::class, 'activate']
)->name('exams.activate');

        Route::post('answers/{answer}/score', [ResultController::class, 'updateScore'])->name('answers.updateScore');
    });


Route::middleware(['auth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/', [SiswaExamController::class, 'index'])->name('dashboard');
        Route::get('exams', [SiswaExamController::class, 'index'])->name('exams.index');
        Route::get('exams/{exam}', [SiswaExamController::class, 'show'])->name('exams.show');
        Route::post('exams/{exam}/submit', [SiswaExamController::class, 'submit'])->name('exams.submit');
        Route::get('exams/{exam}/result', [SiswaExamController::class, 'result'])->name('exams.result');
    });

Route::get('/guru/exams/{exam}/export', 
    [ExamController::class, 'export']
)->name('guru.exams.export');

