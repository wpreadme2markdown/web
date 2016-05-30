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

        $slim->get('/', function(...$args) {
            return (new Controller($this, ...$args))->index();
        });

        $slim->post('/', function(...$args) {
            return (new Controller($this, ...$args))->convert();
        });

        $slim->post('/download', function (...$args) {
            return (new Controller($this, ...$args))->download();
        });

        $slim->get('/about', function (...$args) {
            return (new Controller($this, ...$args))->about();
        });

        $slim->get('/wp2md', function (...$args) {
            return (new Controller($this, ...$args))->wp2md();
        });

        $slim->run();
    }
}
