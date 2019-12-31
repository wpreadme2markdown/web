<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

declare(strict_types=1);

namespace WPReadme2Markdown\Web;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use Parsedown;
use Slim\Views\PhpRenderer;

use function DI\create;
use function DI\get;

class App
{
    /**
     * @var \Slim\App
     */
    public static $slim;
    public static $path;

    public static function run($path)
    {
        $container = new Container();

        $container->set(PhpRenderer::class, create()->constructor($path . '/src/templates/', [], 'layout.phtml'));
        $container->set(Parsedown::class, create());
        $container->set(Controller::class, create());
        $container->set('controller', get(Controller::class));

        self::$path = $path;
        self::$slim = $slim = Bridge::create($container);

        $slim->get( '/',            "controller::index");
        $slim->post('/',            "controller::convert");
        $slim->post('/download',    "controller::download");
        $slim->get( '/about',       "controller::about");
        $slim->get( '/wp2md',       "controller::wp2md");

        $slim->run();
    }
}
