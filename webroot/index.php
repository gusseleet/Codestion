<?php

include __DIR__ . '/../app/src/Logger/CLoggingHelper.php';

require __DIR__.'/config_with_app.php';

if($_SERVER['HTTP_HOST'] == 'localhost:8080') {
    $app->theme->configure(ANAX_APP_PATH . 'config/myTheme.php');
}
else {
    $app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
}
$app->navbar->configure(ANAX_APP_PATH . 'config/myNavbar.php');


$di->set('CommentController', function() use ($di) {
    $controller = new gel\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});



$app->router->add('', function () use ($app) {

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');




    $app->views->add('me/homepage', [
        'content' => $content,
        'byline' => null,
    ]);

    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => ' homepage',
    ]);


});


$app->router->add('about', function () use ($app) {

    $app->theme->setTitle("About");

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


    $app->views->add('me/redovisning', [
        'content' => $content,
        'byline' => null,
    ]);

});

/*
$app->router->add('sourcecode', function () use ($app) {

    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle('Källkod');

    $source = new \Mos\Source\CSource([
        'secure_dir' => '../..',
        'base_dir' => '../..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/sourcecode', ['content' => $source->View()]);

});
*/



$app->router->add('users', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'Users',
        'action'     => ' active',
    ]);

});

$app->router->add('comments', function() use ($app) {

    $app->dispatcher->forward([
        'controller' => 'Comment',
        'action'     => ' view',
    ]);

    $app->dispatcher->forward([
        'controller' => 'Comment',
        'action'     => ' add',
    ]);

});


$app->router->add('setup', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'Users',
        'action'     => ' setupUsers',
    ]);
});

$app->router->add('setupComments', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'Comment',
        'action'     => ' setup',
    ]);
});


$app->router->add('setupQuestions', function() use ($app) {

    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => ' setUpQuestions'
    ]);

});


$app->router->add('tags', function() use ($app) {

    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => ' getTags'
    ]);

});

$app->router->add('questions', function() use ($app) {

    $app->dispatcher->forward([
        'controller' => 'Questions',
        'action'     => ' listAllQuestions'
    ]);

});

$app->router->handle();
$app->theme->render();
$app->errorOutput->getMessage();