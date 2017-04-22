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
        $router->removeExtraSlashes(TRUE);

        $router->add('/admin', [
            'namespace' => 'Admin',
        ]);
        $router->add('/admin/:controller', [
            'namespace' => 'Admin',
            'controller' => 1,
        ]);
        $router->add('/admin/:controller/:action/:params', [
            'namespace' => 'Admin',
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ]);
        $router->add('/frontend/:controller/:action/:params', [
            'module' => 'frontend',
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ]);
        return $router;
    });

    // 组件需要 start 如果 PHP 配置了 session 自动开启，则不需要
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    $di->setShared('session', $session);

    // Handle the request
    $application = new Phalcon\Mvc\Application();

    // 注册模块，包含设置模块定义类加载位置
    $application->registerModules(
        array(
            'frontend' => array(
                'namespaceName' => 'Frontend',
                'className'     => 'Module',
                'path'          => __DIR__.'/../apps/modules/frontend/Module.php',
            ),
        )
    );

    echo $application->handle()->getContent();

} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}
