<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CompanyMaturityScoringController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\CompanyQuestionController;
use App\Http\Controllers\HackerattackController;
use App\Http\Controllers\HardwareobjectsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\InterfacesController;
use App\Http\Controllers\KillChainController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MapObjectsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ScenarioController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

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

Route::post('/language-switch', [LanguageController::class, 'languageSwitch'])->name('language.switch');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [MapController::class, 'index']);

    Route::prefix('maps')->group(function () {
        Route::get('/', [MapController::class, 'index'])->name('maps.index');
        Route::post('/add', [MapController::class, 'store'])->name('maps.add.post');
        Route::get('/add', [MapController::class, 'addModal'])->name('maps.addModal');
        Route::get('/{map}/edit', [MapController::class, 'edit'])->name('maps.edit');
        Route::put('/{map}/update', [MapController::class, 'update'])->name('maps.update');
        Route::delete('/{map}/destroy', [MapController::class, 'destroy'])->name('maps.destroy');
        Route::get('/{map}/editProperties', [MapController::class, 'editModal'])->name('maps.editModal');
        Route::get('/img/{id}', [ImageController::class, 'getImage'])->name('maps.getImage');
    });

    Route::prefix('kill-chain')->group(function () {
        Route::get('/', [KillChainController::class, 'index'])->name('killchain.index');
        Route::get('/scenarios', [KillChainController::class, 'scenarios'])->name('killchain.scenarios'); //NOTE: extrem long loading casued by calculating every possible scenario for the all AttackSteps.
    });
    Route::prefix('scenarios')->group(function () {
        Route::get('/', [ScenarioController::class, 'index'])->name('scenarios');
        Route::post('/add', [ScenarioController::class, 'store'])->name('scenarios.add.post');
    });
    Route::prefix('hardwareobjects')->group(function () {
        Route::get('/', [HardwareobjectsController::class, 'index'])->name('hardwareobjects.show');
        Route::get('/{id}/interfaces/', [HardwareobjectsController::class, 'InterfacesFromHardwareObject'])->name('hardwareobjectWithInterface.show');
    });

    Route::prefix('hackerattacks')->group(function () {
        Route::get('/SimAttackTest', [HackerattackController::class, 'run_attack'])->name('GetHackerAttackSim');
        Route::post('/SimAttackTest', [HackerattackController::class, 'run_attack'])->name('PostHackerAttackSim');
        Route::get('/LoadReport', [HackerattackController::class, 'load_report'])->name('HackAttackLoadReport');
    });

    Route::prefix('interfaces')->group(function () {
        Route::get('/', [InterfacesController::class, 'get_all'])->name('interaces.show');
        Route::get('/{id}', [InterfacesController::class, 'get'])->name('interace.show');
    });

    Route::prefix('mapobjects')->group(function () {
        Route::get('/', [MapObjectsController::class, 'index'])->name('mapobjects.show');
        Route::get('/add', [MapObjectsController::class, 'add'])->name('mapobjects.add');
        Route::post('/{id}/add', [MapObjectsController::class, 'add'])->name('mapobjects.add.post');
        Route::get('/{id}/add', [MapObjectsController::class, 'addModal'])->name('mapobjects.addModal');
        Route::get('/{id}/edit', [MapObjectsController::class, 'edit'])->name('mapobjects.edit');
        Route::post('/{id}/update', [MapObjectsController::class, 'update'])->name('mapobjects.update');
        Route::post('/{id}/updateconnections', [MapObjectsController::class, 'updateConnections'])->name('mapobjects.updateConnections');
        Route::post('/{id}/updatepositions', [MapObjectsController::class, 'updatePositions'])->name('mapobjects.updatePositions');
        Route::delete('/{id}/destroy', [MapObjectsController::class, 'destroy'])->name('mapobjects.destroy');

        Route::get('/settings', [MapObjectsController::class, 'settings'])->name('mapobjects.settings');
    });

    Route::get('user-management', function () {
        return view('laravel-examples/user-management');
    })->name('user-management');

    Route::prefix('settings')->group(function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/', [CompanyProfileController::class, 'store']);
        Route::get('/{id}', [CompanyProfileController::class, 'show']);
    });

    Route::prefix('company')->group(function () {

        Route::get('/settings', [CompanyQuestionController::class, 'index'])->name('company.settings');
        Route::post('/settings', [CompanyQuestionController::class, 'update'])->name('company.update');
        Route::post('/maturity-levels', [CompanyMaturityScoringController::class, 'getCompanyBaseline'])->name('company.maturity-levels');
        Route::post('/maturity-score', [CompanyMaturityScoringController::class, 'getMaturityScore'])->name('company.maturity-score');
        Route::post('/recommendation', [CompanyMaturityScoringController::class, 'getRecommendation'])->name('company.recommendation');
    });

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
        return view('dashboard');
    })->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
