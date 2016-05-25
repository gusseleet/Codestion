<?php

require __DIR__.'/config_with_app.php';

if($_SERVER['HTTP_HOST'] == 'localhost:8080') {
    $app->theme->configure(ANAX_APP_PATH . 'config/myTheme.php');
}
else {
    $app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
}



$app->navbar->configure(ANAX_APP_PATH . 'config/myNavbar.php');

$di->set('formController', function () use ($di){

    $controller = new \Anax\HTMLForm\FormController();
    $controller->setDI($di);
    return $controller;



});



$di->set('UsersController', function () use ($di){

    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;



});




$app->router->add('', function () use ($app) {

    $app->db->setVerbose(false);

    $app->dispatcher->forward([
        'controller' => 'Users',
        'action'     => 'list',
    ]);

     var_dump($app->db->getVerbose());



});


$app->router->add('setup', function() use ($app) {

    $app->db->setup();

});
$app->router->handle();
$app->theme->render();