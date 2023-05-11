<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RegistrosController;
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

Route::get('', function () {
    $response = Http::get('https://rickandmortyapi.com/api/character?page=1');
    $data = $response->json();
    dd($data["results"]);
});

Route::get('load', [RegistrosController::class, 'index']);
Route::get('/characters', [RegistrosController::class, 'getCharactersFromDatabase']);
Route::get('/count', [RegistrosController::class, 'countCharacters']);
Route::get('/character/{id}', [RegistrosController::class, 'getCharacterFromId']);
Route::get('/characters', [RegistrosController::class, 'getCharactersFromPage']);
Route::put('update', [RegistrosController::class, 'update']);
