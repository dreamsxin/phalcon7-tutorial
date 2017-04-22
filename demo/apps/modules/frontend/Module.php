<?php

namespace Frontend;

class Module implements \Phalcon\Mvc\ModuleDefinitionInterface
{
    /**
     * 注册自定义加载器
     */
    public function registerAutoloaders(\Phalcon\DiInterface $di)
    {
		// 由于我们外面已经实例化一个加载器，所以这里我们使用已有的加载器
        $loader = \Phalcon\Loader::getDefault();

        $loader->registerNamespaces(
            array(
                'Frontend' => array(
                    __DIR__.'/controllers',
                    __DIR__.'/models',
                ),
            )
        );
    }

    /**
     * 注册自定义服务
     */
    public function registerServices(\Phalcon\DiInterface $di)
    {
        // Registering the view component
        $di->set('view', function () {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(__DIR__.'/views/');
            return $view;
        });
    }
}
