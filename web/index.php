<?php
    // web/index.php
    
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/delegates/auth_delegate.php';
    require_once __DIR__.'/delegates/friendship_delegate.php';
    require_once __DIR__.'/delegates/user_delegate.php';
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    
    $app = new Silex\Application();
    $app['debug']=true;
    
    // Service provider registrations go here
    $app->register(new Silex\Provider\SessionServiceProvider());
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/views',
    ));

    //GLOBALS
    $app['webroot'] = getenv('WEBROOT');
    if ($app['webroot'] == false){
        $app['webroot'] = $app['webroot'].'';
    }
    $app['twig']->addGlobal('webroot', $app['webroot']);

    // Routes go here
    $app->before(function(Request $request){
        $request->getSession()->start();
       //require_once 'seed.php'; 
    });

    $app->get('/', function(Request $request) use ($app) {
        return "<h1>Hello World</h1>";
    });
    
    $app->get('/greeting/{person}', function(Request $request, $person) use ($app) {
        return $app['twig']->render('hello.twig', array('name'=>$person));
    });

    $app->get('/settings', function(Request $request) use ($app) {
        $model = array('name' => $app['session']->get('name'),
                      'email' => $app['session']->get('email'));
        return $app['twig']->render('settings.twig', $model);
    });

    $app->post('/info/basic', function(Request $request) use ($app) {
        $id = $app['session']->get('id');
        update_user_name($id, $request->get('user-name'));
        update_user_email($id, $request->get('user-email'));
        
        return $app->redirect($app['webroot'].'settings');
    });

    $app->post('/info/avatar', function(Request $request) use ($app){
        $avatarFile = $request->files->get('avatar-file');
        $avatarFile->move('images', $avatarFile->getClientOriginalName());
        return $app->redirect($app['webroot'].'settings');
    });

    $app->get('/friends', function(Request $request) use ($app) {
        if (!$app['session']->has('id')){
            return $app->redirect($app['webroot'].'login');
        }
        
        $friend_requests = get_friend_request_users($app['session']->get('id'));
        $friends = get_friend_users($app['session']->get('id'));
        $model = array("friend_requests" => $friend_requests, "friends" => $friends);
        
        return $app['twig']->render('friends.twig', $model);
        
    });

    $app->get('/login', function(Request $request) use ($app){
       return $app['twig']->render('login.twig', array()); 
    });

    $app->post('/login', function(Request $request) use ($app){
        //Grab form data
        $formEmail = $request->get('email');
        $formPassword = $request->get('password');
        
        //Validation
        $errors = array();
        $user = get_user_by_email($formEmail);
        
        if ($user == null){
            
            $errors['email'] = "This email is not registered.";
            $model = array('email' => $formEmail, 'errors' => $errors);
            return $app['twig']->render('login.twig', $model);
        }else{
            //Login
            $app['session']->set('id', $user['id']);
            $app['session']->set('name', $user['name']);
            $app['session']->set('email', $user['email']);
            $app['session']->set('avatar', $user['avatar_path']);
            return $app->redirect($app['webroot'].'settings');
        }
    });

    $app->post('/search', function(Request $request) use ($app){
       if(!$app['session']->has('id')){
           return $app->redirect($app['webroot'].'login');
       } 
        
        $search_input = $request->get('searchTerm');
        $results = search_for_users($search_input);
        $model = array("results" => $results);
        
        return $app['twig']->render('search_results.twig', $model);
    });

    // Run the app
    $app->run();
?>