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
use App\Http\Controllers\AgentDashboardController;
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

/*
|--------------------------------------------------------------------------
| Routes Agent
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->middleware(['auth', 'agent'])->group(function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
    Route::post('/perte/{perte}/valider', [AgentDashboardController::class, 'valider'])->name('perte.valider');
    Route::post('/perte/{perte}/rejeter', [AgentDashboardController::class, 'rejeter'])->name('perte.rejeter');
    Route::get('/perte/{perte}', [AgentDashboardController::class, 'show'])->name('perte.show');
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Gestion des types de pièces
    Route::get('/types-pieces', [TypePieceController::class, 'index'])->name('types-pieces.index');
    Route::get('/types-pieces/create', [TypePieceController::class, 'create'])->name('types-pieces.create');
    Route::post('/types-pieces', [TypePieceController::class, 'store'])->name('types-pieces.store');
    
    // ✅ AJOUT : Gestion des rôles (page temporaire)
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');
});

// Routes d'authentification (login, register, logout)
require __DIR__.'/auth.php';