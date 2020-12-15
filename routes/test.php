<?php
$app = app('Dingo\Api\Routing\Router');

$app->version('v1', [
	'namespace' => 'App\Api\Test'
],function ($api) {
	$api->get('/test', 'TestController@test');
});