<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace WPReadme2Markdown\Web;

use Slim\App as SlimApp;

class App
{
    /**
     * @var \Slim\App
     */
    public static $slim;
    public static $path;

    public static function run($path)
    {
        self::$path = $path;
        self::$slim = $slim = new SlimApp();

        $container = $slim->getContainer();

        $container['view'] = function () use ($path) {
            return new View($path . '/src/templates/');
        };

        $controller = Controller::class;

        $slim->get( '/',            "{$controller}:index");
        $slim->post('/',            "{$controller}:convert");
        $slim->post('/download',    "{$controller}:download");
        $slim->get( '/about',       "{$controller}:about");
        $slim->get( '/wp2md',       "{$controller}:wp2md");

        $slim->run();
    }
}
