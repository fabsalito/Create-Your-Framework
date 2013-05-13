<?php
 
// framework/front.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
 
// crea petición desde globales PHP
$request = Request::createFromGlobals();

// carga rutas de la app
$routes = include __DIR__.'/../src/app.php';

// obtiene contexto de la petición
$context = new Routing\RequestContext();
$context->fromRequest($request);

// crea nuevo matcher seteando contexto y la tabla de rutas de la app
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
 
try {
    // carga pares de la ruta coincidente a la tabla de simbolos actual
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    
    // activa almacenamiento en buffer
    ob_start();

    // carga la página indicada ($_route está cargada en la tabla de símbolos)
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
    
    // crea respuesta en base al contenido del buffer
    $response = new Response(ob_get_clean());

} catch (Routing\Exception\ResourceNotFoundException $e) {
    // crea respuesta para página no encontrada
    $response = new Response('Not Found', 404);

} catch (Exception $e) {
    // crea respuesta para excepción
    $response = new Response('An error occurred', 500);
}
 
// envía respuesta
$response->send();