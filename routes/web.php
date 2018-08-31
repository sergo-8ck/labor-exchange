<?php

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(
  [
    'prefix' => 'cabinet',
    'as' => 'cabinet.',
    'namespace' => 'Cabinet',
    'middleware' => ['auth'],
  ],
  function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('vacancies', 'VacancyController');
    Route::resource('profile', 'ProfileController');
  }
);

Route::group(
  [
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'can:admin-panel'],
  ],
  function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('users', 'UsersController');
    Route::resource('vacancies', 'VacancyController');
    Route::resource('profile', 'ProfileController');
    Route::post('/vacancy/{vacancy}/moderate', 'VacancyController@moderate')->name('vacancies.moderate');
  }
);

