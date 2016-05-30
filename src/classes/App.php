<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace WPReadme2Markdown\Web;

use Slim\App as Slim;

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
        self::$slim = $slim = new Slim([
            'templates.path' => $path . '/src/templates',
            'view' => View::class,
            'debug' => false,
        ]);

        $container = $slim->getContainer();

        $container['view'] = function () use ($path) {
            return new View($path . '/src/templates/');
        };

        $slim->get('/', function(...$args) {
            (new Controller(...$args))->index();
        });

        $slim->post('/', function(...$args) {
            (new Controller(...$args))->convert();
        });

        $slim->post('/download', function (...$args) {
            (new Controller(...$args))->download();
        });

        $slim->get('/about', function (...$args) {
            (new Controller(...$args))->about();
        });

        $slim->get('/wp2md', function (...$args) {
            (new Controller(...$args))->wp2md();
        });

        $slim->run();
    }
}
