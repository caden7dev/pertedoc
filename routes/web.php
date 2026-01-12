<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\PerteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\TypePieceController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Afficher le formulaire de réinitialisation
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Envoyer le lien de réinitialisation
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');

// Afficher le formulaire de nouveau mot de passe
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.reset');

// Enregistrer le nouveau mot de passe
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.update');

/*
|--------------------------------------------------------------------------
| Routes protégées (authentification requise)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Déclarations de perte
    Route::get('/perte/nouvelle', [PerteController::class, 'create'])->name('perte.create');
    Route::post('/perte', [PerteController::class, 'store'])->name('perte.store');
    Route::get('/mes-declarations', [PerteController::class, 'index'])->name('perte.index');
    Route::get('/perte/{id}', [PerteController::class, 'show'])->name('perte.show');
    
});

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:agent')->group(function () {
        Route::get('/agent/dashboard', [AgentDashboardController::class, 'index'])
            ->name('agent.dashboard');

        Route::post('/agent/perte/{perte}/valider', [AgentDashboardController::class, 'valider'])
            ->name('agent.perte.valider');

        Route::post('/agent/perte/{perte}/rejeter', [AgentDashboardController::class, 'rejeter'])
            ->name('agent.perte.rejeter');
    });

});
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/types-pieces', [TypePieceController::class, 'index'])
        ->name('types-pieces.index');
});


// Routes d'authentification (login, register, logout)
require __DIR__.'/auth.php';