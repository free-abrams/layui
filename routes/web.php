<?php
// use Illuminate\Support\Facades\Route;
//use Dingo\Api\Routing\Route;

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
$app = app('Dingo\Api\Routing\Router');

$app->version('v1', [
	'namespace' => 'App\Api\Test'
],function ($api) {
	$api->get('/test', 'TestController@test');
	$api->get('/cate', 'TestController@cate');
	$api->get('/test-job', 'TestController@testJob');
});