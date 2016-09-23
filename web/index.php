<?php
    require_once __DIR__.'/../vendor/autoload.php';
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    // Create a Silex Application
    $app = new Silex\Application();

    //Service Provider registrations go here

    //Routes go here
    $app->get('/', function(Request $request) use ($app){
       return "<h1>Hello World</h1>" ;
    });
    //Run the app
    $app->run();
    
?>