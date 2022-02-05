<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

declare(strict_types=1);

namespace WPReadme2Markdown\Web;

use League\CommonMark\ConverterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\PhpRenderer;
use WPReadme2Markdown\Converter;

class Controller
{
    public function index(ServerRequest $request, Response $response, PhpRenderer $view): ResponseInterface
    {
        return $view->render($response, 'index.phtml', [
            'flash' => $request->getAttribute('flash'),
        ]);
    }

    public function about(Response $response, PhpRenderer $view): ResponseInterface
    {
        return $view->render($response, 'about.phtml', [
            'title' => 'Description',
        ]);
    }

    public function wp2md(
        Response $response,
        PhpRenderer $view,
        ContainerInterface $container,
        ConverterInterface $converter,
    ): ResponseInterface {
        $wp2md_readme = file_get_contents($container->get('path') . '/vendor/wpreadme2markdown/wp2md/README.md');

        return $view->render($response, 'wp2md.phtml', [
            'readme' => $converter->convert($wp2md_readme)->getContent(),
            'title'  => 'WP2MD CLI'
        ]);
    }

    public function convert(
        ServerRequest $request,
        Response $response,
        PhpRenderer $view,
        ConverterInterface $converter,
    ): ResponseInterface {
        $readme = $request->getParam('readme-text');

        /** @var UploadedFileInterface $readmeFile */
        $readmeFile = $request->getUploadedFiles()['readme-file'];

        if ($readmeFile && $readmeFile->getError() === UPLOAD_ERR_OK) {
            $readme = $readmeFile->getStream()->getContents();
        }

        if (empty($readme)) {
            $flash = ['error' => 'Either Readme content or Readme file must be set'];
            return $this->index($request->withAttribute('flash', $flash), $response, $view);
        }

        $slug = $request->getParam('plugin-slug');

        if (empty(trim($slug))) {
            $slug = null;
        }

        $markdown = Converter::convert($readme, $slug);

        // also render demo
        $markdown_html = $converter->convert($markdown)->getContent();

        return $view->render($response, 'convert.phtml', [
            'markdown' => $markdown,
            'markdown_html' => $markdown_html,
        ]);
    }

    public function download(ServerRequest $request, Response $response): ResponseInterface
    {
        $markdown = $request->getParsedBodyParam('markdown');

        $response = $response->
            withHeader('Content-Type', 'application/octet-stream')->
            withHeader('Content-Transfer-Encoding', 'binary')->
            withHeader('Content-disposition', 'attachment; filename="README.md"');
        $response->getBody()->write($markdown);

        return $response;
    }
}
