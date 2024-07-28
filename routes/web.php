<?php

use App\Http\Controllers\GeoNodeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [GeoNodeController::class, 'index']);

Route::get('/geoserver-geojson', [GeoNodeController::class, 'getGeoJSONData']);

Route::get('/geoserver-geojson-2', [GeoNodeController::class, 'getGeoJSONData2']);

Route::get('/geoserver-geojson-3', [GeoNodeController::class, 'getGeoJSONData3']);

Route::get('/geoserver-geojson-4', [GeoNodeController::class, 'getGeoJSONData4']);

Route::get('/geoserver-geojson-5', [GeoNodeController::class, 'getGeoJSONData5']);

Route::get('/geoserver-pretier-geojson', [GeoNodeController::class, 'getGeoJSONDataPretier']);
