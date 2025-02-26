<?php

use App\Http\Controllers\ScrapeController;
use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('/', function () use ($router) {
    return view('index');
});

$router->group(['prefix' => 'api'], function (Router $router) {
    $router->get('/start', ['uses' => 'ScrapeController@scrape']);
    $router->get('/status', ['uses' => 'ScrapeController@status']);
});
