<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

declare(strict_types=1);

namespace WPReadme2Markdown\Web;

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use League\CommonMark\ConverterInterface;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use Slim\Views\PhpRenderer;

use function DI\create;
use function DI\get;
use function DI\value;

class App
{
    public static function run(string $path)
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(false);
        $builder->addDefinitions([
            'path' => value($path),
            PhpRenderer::class => create()->constructor($path . '/src/templates/', [], 'layout.phtml'),
            ConverterInterface::class => create(GithubFlavoredMarkdownConverter::class),
            Controller::class => create(),
            'controller' => get(Controller::class),
        ]);

        $container = $builder->build();

        $slim = Bridge::create($container);

        $slim->get( '/',            "controller::index");
        $slim->post('/',            "controller::convert");
        $slim->post('/download',    "controller::download");
        $slim->get( '/about',       "controller::about");
        $slim->get( '/wp2md',       "controller::wp2md");

        $slim->run();
    }
}
