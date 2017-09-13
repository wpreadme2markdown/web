<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace WPReadme2Markdown\Web;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use WPReadme2Markdown\Converter;

class Controller
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        return $this->render($response, 'index');
    }

    public function about(Request $request, Response $response)
    {
        return $this->render($response, 'about', [
            'title' => 'Description',
        ]);
    }

    public function wp2md(Request $request, Response $response)
    {
        $wp2md_readme = file_get_contents(App::$path . '/vendor/wpreadme2markdown/wp2md/README.md');

        return $this->render($response, 'wp2md', [
            'readme' => \Parsedown::instance()->text($wp2md_readme),
            'title'  => 'WP2MD CLI'
        ]);
    }

    public function convert(Request $request, Response $response)
    {
        $readme = $request->getParam('readme-text');

        /** @var UploadedFileInterface $readmeFile */
        $readmeFile = $request->getUploadedFiles()['readme-file'];

        if ($readmeFile && $readmeFile->getError() === UPLOAD_ERR_OK) {
            $readme = $readmeFile->getStream()->getContents();
        }

        if (empty($readme)) {
            $this->flashNow('error', 'Either Readme content or Readme file must be set');
            return $this->index($request, $response);
        }

        $slug = $request->getParam('plugin-slug');

        if (empty(trim($slug))) {
            $slug = null;
        }

        $markdown = Converter::convert($readme, $slug);

        // also render demo
        $markdown_html = \Parsedown::instance()->text($markdown);

        return $this->render($response, 'convert', [
            'markdown' => $markdown,
            'markdown_html' => $markdown_html,
        ]);
    }

    public function download(Request $request, Response $response)
    {
        $markdown = $request->getParsedBodyParam('markdown');

        $response = $response->
            withHeader('Content-Type', 'application/octet-stream')->
            withHeader('Content-Transfer-Encoding', 'binary')->
            withHeader('Content-disposition', 'attachment; filename="README.md"');
        $response->getBody()->write($markdown);

        return $response;
    }

    private function flashNow($key, $string)
    {
        $this->container->get('view')->flashNow($key, $string);
    }

    private function render(Response $response, $template, $args = [])
    {
        return $this->container->get('view')->render($response, $template, $args);
    }
}
