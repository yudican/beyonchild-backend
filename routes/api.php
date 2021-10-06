<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChildrenController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\MasterQuisController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\SchollController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', [AuthController::class, 'login'])->name('client.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('client.register');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('school/level', [SchollController::class, 'schoolLevel'])->name('school.level');
    Route::get('school/location', [SchollController::class, 'schoolLocation'])->name('school.location');
    Route::get('school/facilities', [SchollController::class, 'schoolFacility'])->name('school.facilities');
    Route::get('school/all', [SchollController::class, 'schools'])->name('school.all');
    Route::get('school/detail/level/{education_level_id?}', [SchollController::class, 'schoolByLevel'])->name('school.by_level');
    Route::get('school/detail/location/{school_location_id?}', [SchollController::class, 'schoolByLocation'])->name('school.by_location');
    Route::post('school/location_and_level', [SchollController::class, 'schoolByLocationAndLevel'])->name('school.location_and_level');
    Route::post('school/recomendation', [SchollController::class, 'schoolRecomendation'])->name('school.recomendation');
    Route::get('school/expert/{school_id}', [SchollController::class, 'schoolExperts']);

    // quizz
    Route::get('quiz/multiple-intelegence-category', [MasterQuisController::class, 'multipleIntelegenceCategory'])->name('multiple.intelegence-category');
    Route::get('quiz/multiple-intelegence-question/{category_id?}', [MasterQuisController::class, 'multipleIntelegenceQuestion'])->name('multiple.intelegence-question');
    Route::get('quiz/sdq-question', [MasterQuisController::class, 'sdqQuestion'])->name('sdq-question');

    // profile
    Route::get('profile', [UserController::class, 'getProfile']);
    Route::get('user/children', [ChildrenController::class, 'getChildren']);
    Route::post('user/children', [ChildrenController::class, 'addChildren']);
    Route::put('user/children/{id?}', [ChildrenController::class, 'updateChildren']);

    // mentor
    Route::get('mentor', [MentorController::class, 'getMentor']);
    Route::get('mentor/education/{education_level_id?}', [MentorController::class, 'getMentorByEducationLevel']);
    Route::get('mentor/{mentor_id?}', [MentorController::class, 'getMentorDetail']);
    Route::get('mentor/schedule/{mentor_schedule_id?}', [MentorController::class, 'getMentorSchedule']);

    // event
    Route::get('event', [EventController::class, 'getEvent']);
    Route::get('event/detail/{event_id?}', [EventController::class, 'getEventDetail']);
    Route::get('event/category_event', [EventController::class, 'getEventCategory']);
});
