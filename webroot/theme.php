<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-08
 * Time: 09:49
 */

require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/themeNavbar.php');
$app->theme->setVariable('title', "Theme");


$app->router->add('', function() use ($app){


    $app->theme->setTitle('Tema');

    $app->views->addString('Hejsan, tema...!', 'main');

});

$app->router->add('regioner', function() use ($app) {

    $app->theme->addStylesheet('css/anax-grid/regions.css');
    $app->theme->setTitle("Regioner");

    $app->views->addString('flash', 'flash')
        ->addString('featured-1', 'featured-1')
        ->addString('featured-2', 'featured-2')
        ->addString('featured-3', 'featured-3')
        ->addString('main', 'main')
        ->addString('sidebar', 'sidebar')
        ->addString('triptych-1', 'triptych-1')
        ->addString('triptych-2', 'triptych-2')
        ->addString('triptych-3', 'triptych-3')
        ->addString('footer-col-1', 'footer-col-1')
        ->addString('footer-col-2', 'footer-col-2')
        ->addString('footer-col-3', 'footer-col-3')
        ->addString('footer-col-4', 'footer-col-4');

});





$app->router->add('typography', function() use ($app){


    $content  = $app->fileContent->get('typography.php');

    $app->views->add('default/article',
        ['content' => $content,], 'main');


    $content = $app->fileContent->get('typoRight.php');

    $app->views->add('default/article',
    ['content' => $content,], 'sidebar');

});


$app->router->add('fontAwesome', function() use ($app) {

   $content = $app->fileContent->get('fontAwesome.php');

    $app->views->add('default/article',
        ['content' => $content], 'main');

    $content = $app->fileContent->get('fontAwesomeSideBar.php');

    $app->views->add('default/article',
        ['content' => $content], 'sidebar');


    $app->views->addString('<h1> Testar exempel med Font Awesome </h1>', 'flash');
});

$app->router->handle();
$app->theme->render();