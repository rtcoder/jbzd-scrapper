<?php

use App\Console\Kernel;
use App\Exceptions\Handler;
use Illuminate\Contracts\Console\Kernel as AbstractKernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Laravel\Lumen\Application;
use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;

require_once __DIR__ . '/../vendor/autoload.php';

(new LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Application(dirname(__DIR__));

$app->withFacades();

$app->withEloquent();

$app->singleton(ExceptionHandler::class, Handler::class);

$app->singleton(AbstractKernel::class, Kernel::class);

$app->configure('app');


// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

$app->singleton(ViewFactory::class, function ($app) {
    return $app->make('view');
});


return $app;
