<?php
 
// example.com/src/app.php
 
 use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }
 
    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

// crea una nueva coleeción de rutas
$routes = new Routing\RouteCollection();

// agrega ruta para /hello/{name}
$routes->add('hello', new Routing\Route('/hello/{name}', array(
    'name' => 'World',
    '_controller' => function($request){
        return render_template($request);
    }
)));

// agrega ruta para /bye
$routes->add('bye', new Routing\Route('/bye', array(
    '_controller' => function($request){
        return render_template($request);
    }
)));

// agrega ruta para is_leap_year/{year}
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => function ($request) {
        if (is_leap_year($request->attributes->get('year'))) {
            $response = new Response('Yep, this is a leap year!');

            return $response;
        }
 
        $response = new Response('Nope, this is not a leap year.');

        return $response;
    }
)));
 
return $routes;