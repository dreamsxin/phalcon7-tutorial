<?php

try {
    Phalcon\Debug::disable();

    // Register an autoloader
    $loader = new Phalcon\Loader();
    $loader->registerDirs(array(
        __DIR__.'/../apps/controllers/',
        __DIR__.'/../apps/models/'
    ))->register();

    // Create a DI
    $di = new Phalcon\Di\FactoryDefault();

    // Setup the view component
    $di->set('view', function () {
        $view = new Phalcon\Mvc\View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function () {
        $url = new Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });

    $di->set('db', function () {
        return new Phalcon\Db\Adapter\Pdo\Sqlite(
            array(
                "dbname" => __DIR__."/../data/demo.db"
            )
        );
    });

    $di->set('router', function () {
        $router = new Phalcon\Mvc\Router;
        $router->add('/admin', [
            'namespace' => 'Admin',
        ]);
        $router->add('/admin/:controller', [
            'namespace' => 'Admin',
            'controller' => 1,
        ]);
        $router->add('/admin/:controller/:action/:params', [
            'namespace' => 'Admin',
            'controller' => 1, // 第一个正则匹配的数据
            'action' => 2,
            'params' => 3
        ]);
        return $router;
    });

    // Handle the request
    $application = new Phalcon\Mvc\Application();

    echo $application->handle()->getContent();

} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}
