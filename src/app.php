<?php
 
// example.com/src/app.php
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;


// crea una nueva coleeción de rutas
$routes = new Routing\RouteCollection();

// agrega ruta para is_leap_year/{year}
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => 'Calendar\\Controller\\LeapYearController::indexAction',
)));

// agrega ruta para /hello/{name}
$routes->add('hello', new Routing\Route('/hello/{name}', array(
    'name' => 'World',
    '_controller' => 'Greeting\\Controller\\GreetingController::helloAction',
)));

// agrega ruta para /bye
$routes->add('bye', new Routing\Route('/bye', array(
    '_controller' => 'Greeting\\Controller\\GreetingController::byeAction',
)));

return $routes;