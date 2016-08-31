<?php

/**
 * Composer with Twig and PSR-4 (class autoloader).
 * For web template used "Mobile-first Responsive" from http://www.initializr.com
 */
require '../vendor/autoload.php';


/**
 * Init Settings
 */
new \App\Settings;

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);

//:apiemy wszystkie errory i wysylamy do naszych funkcji
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('{controller}/{action}');
//$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('home', ['controller' => 'Home', 'action' => 'index']);
//$router->add('home/index', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts/index', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/pl/index', ['controller' => 'Posts', 'language' => 'pl' ,'action' => 'index']);
//$router->add('posts/en/index', ['controller' => 'Posts', 'language' => 'en' ,'action' => 'index']);  

$router->dispatch($_SERVER['QUERY_STRING']);
