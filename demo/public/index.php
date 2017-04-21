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

    // Handle the request
    $application = new Phalcon\Mvc\Application();

    echo $application->handle()->getContent();

} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}
