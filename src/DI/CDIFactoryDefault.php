<?php

namespace Anax\DI;

/**
 * Anax base class implementing Dependency Injection / Service Locator
 * of the services used by the framework, using lazy loading.
 *
 */
class CDIFactoryDefault extends CDI
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        require ANAX_APP_PATH . 'config/error_reporting.php';

        $this->setShared('response', function () {
            $response = new \Anax\Response\CResponseBasic();
            $response->setDI($this);
            return $response;
        });

        $this->setShared('validate', '\Anax\Validate\CValidate');
        $this->setShared('flash', '\Anax\Flash\CFlashBasic');

        $this->set('route', '\Anax\Route\CRouteBasic');
        $this->set('view', '\Anax\View\CViewBasic');

        $this->set('ErrorController', function () {
            $controller = new \Anax\MVC\ErrorController();
            $controller->setDI($this);
            return $controller;
        });

        $this->setShared('log', function () {
            $log = new \Anax\Log\CLogger();
            $log->setContext('development');
            return $log;
        });

        $this->setShared('request', function () {
            $request = new \Anax\Request\CRequestBasic();
            $request->init();
            return $request;
        });

        $this->setShared('url', function () {
            $url = new \Anax\Url\CUrl();
            $url->setSiteUrl($this->request->getSiteUrl());
            $url->setBaseUrl($this->request->getBaseUrl());
            $url->setStaticSiteUrl($this->request->getSiteUrl());
            $url->setStaticBaseUrl($this->request->getBaseUrl());
            $url->setScriptName($this->request->getScriptName());
            $url->setUrlType($url::URL_APPEND);
            return $url;
        });

        $this->setShared('views', function () {
            $views = new \Anax\View\CViewContainerBasic();
            $views->setBasePath(ANAX_APP_PATH . 'view');
            $views->setFileSuffix('.tpl.php');
            $views->setDI($this);
            return $views;
        });

        $this->setShared('router', function () {

            $router = new \Anax\Route\CRouterBasic();
            $router->setDI($this);

            $router->addInternal('403', function () {
                $this->dispatcher->forward([
                    'controller' => 'error',
                    'action' => 'statusCode',
                    'params' => [
                        'code' => 403,
                        'message' => "HTTP Status Code 403: This is a forbidden route.",
                    ],
                ]);
            })->setName('403');

            $router->addInternal('404', function () {
                $this->dispatcher->forward([
                    'controller' => 'error',
                    'action' => 'statusCode',
                    'params' => [
                        'code' => 404,
                        'message' => "HTTP Status Code 404: This route is not found.",
                    ],
                ]);
                $this->dispatcher->forward([
                    'controller' => 'error',
                    'action' => 'displayValidRoutes',
                ]);
            })->setName('404');

            $router->addInternal('500', function () {
                $this->dispatcher->forward([
                    'controller' => 'error',
                    'action' => 'statusCode',
                    'params' => [
                        'code' => 500,
                        'message' => "HTTP Status Code 500: There was an internal server or processing error.",
                    ],
                ]);
            })->setName('500');

            return $router;
        });

        $this->setShared('dispatcher', function () {
            $dispatcher = new \Anax\MVC\CDispatcherBasic();
            $dispatcher->setDI($this);
            return $dispatcher;
        });

        $this->setShared('session', function () {
            $session = new \Anax\Session\CSession();
            $session->configure(ANAX_APP_PATH . 'config/session.php');
            $session->name();
            $session->start();
            return $session;
        });

        $this->setShared('theme', function () {
            $themeEngine = new \Anax\ThemeEngine\CThemeBasic();
            $themeEngine->setDI($this);
            $themeEngine->configure(ANAX_APP_PATH . 'config/theme.php');
            return $themeEngine;
        });

        $this->setShared('form', function(){
            $form = new \Mos\HTMLForm\CForm();
            return $form;

        });


        $this->setShared('UsersController', function(){
            $userC = new \Anax\Users\UsersController();
            $userC->setDI($this);
            return $userC;
        });


        $this->setShared('QuestionsController', function()  {
            $controller = new \gel\Questions\QuestionController();
            $controller->setDI($this);
            return $controller;
        });


        $this->setShared('db', function(){
           $db = new \Mos\Database\CDatabaseBasic();
            $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
            $db->connect();
            return $db;

        });

        $this->setShared('navbar', function () {
            $navbar = new \Anax\Navigation\CNavbar();
            $navbar->setDI($this);
            $navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
            return $navbar;
        });

        $this->set('fileContent', function () {
            $fc = new \Anax\Content\CFileContent();
            $fc->setBasePath(ANAX_APP_PATH . 'content/');
            return $fc;
        });

        $this->setShared('textFilter', function () {
            $filter = new \Anax\Content\CTextFilter();
            $filter->setDI($this);
            $filter->configure(ANAX_APP_PATH . 'config/text_filter.php');
            return $filter;
        });


        $this->setShared('usersTest11', function(){
            $model = new \Anax\Users\User();
            $model->setDI($this);
            return $model;

        });


        $this->setShared('commentModel', function(){
            $model = new \gel\Comment\Comments();
            $model->setDI($this);
            return $model;

        });


        $this->setShared('questionModel', function(){
            $model = new \gel\Questions\Question();
            $model->setDI($this);
            return $model;

        });


        $this->setShared('answerToCommentsModel', function(){
            $model = new \gel\Comment\AnswersToComments();
            $model->setDI($this);
            return $model;

        });

        $this->setShared('votesModel', function(){
            $model = new \gel\Comment\Votes();
            $model->setDI($this);
            return $model;

        });


        $this->setShared('errorOutput', function(){
            $model = new \gel\Popup\CPopup();
            $model->setDI($this);
            return $model;

        });

    }
}
