<?php
$app = app('Dingo\Api\Routing\Router');

$app->version('v1', [
	'namespace' => 'App\Api\Goods'
],function ($api) {
	$api->get('/goods/{id}', 'GoodsController@goods');
	$api->get('/goods-cache', 'GoodsController@caches');
	$api->get('record', 'GoodsController@record');
});