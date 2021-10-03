<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Admin\Event;
use App\Http\Livewire\Admin\EventCategory;
use App\Http\Livewire\Admin\IntelligenceQuestion;
use App\Http\Livewire\Admin\InterestTalent;
use App\Http\Livewire\Admin\Mentor;
use App\Http\Livewire\Admin\School;
use App\Http\Livewire\Admin\SdqQuestion;
use App\Http\Livewire\Admin\SmartCategory;
use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Master\EducationLevel;
use App\Http\Livewire\Master\Facility;
use App\Http\Livewire\Master\SchoolLocation;
use App\Http\Livewire\Settings\Menu;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
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

Route::get('/', function () {
    return redirect('login');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');
    Route::get('/menu', Menu::class)->name('menu');

    // App Route
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Master data
    Route::get('/education-level', EducationLevel::class)->name('education-level');
    Route::get('/school-location', SchoolLocation::class)->name('school-location');
    Route::get('/facility', Facility::class)->name('facility');
    Route::get('/talent', InterestTalent::class)->name('talent');

    // TRANSACTION
    Route::get('/school-list', School::class)->name('school-list');
    Route::get('/mentor', Mentor::class)->name('mentor');


    // quis
    Route::get('/smart-category', SmartCategory::class)->name('smart-category');
    Route::get('/intellegence-question/{category_id}', IntelligenceQuestion::class)->name('intellegence-question');
    Route::get('/sdq-question', SdqQuestion::class)->name('sdq-question');

    // events
    Route::get('/event-category', EventCategory::class)->name('event-category');
    Route::get('/event', Event::class)->name('event');
});
