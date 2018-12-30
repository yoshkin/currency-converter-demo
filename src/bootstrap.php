<?php declare(strict_types = 1);
require_once __DIR__.'/../vendor/autoload.php';

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

$injector = include_once(dirname(__DIR__) . '/src/config/Di.php');

$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    //Frontend Routes
    $r->get('/', ['AYashenkov\Http\Controllers\IndexController', 'index']);
    //API Routes
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->get('/convert/{from}/{to}/{amount}', ['AYashenkov\Http\Controllers\Api\ConverterController', 'index']);
    });
});

/**
 * Set responses
 */
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        /* @var array $params ['from'=> '', 'to' => '', 'amount' => ''] */
        $params = $routeInfo[2];

        $class = $injector->make($className);
        $class->$method($params);
        break;
}

foreach ($response->getHeaders() as $header) {
    header($header, false);
}

echo $response->getContent();