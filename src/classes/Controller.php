<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace WPReadme2Markdown\Web;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use WPReadme2Markdown\Converter;

class Controller
{
    private $request;
    private $response;
    private $arguments;
    private $container;

    public function __construct(ContainerInterface $container, Request $request, Response $response, $arguments = [])
    {
        $this->request      = $request;
        $this->response     = $response;
        $this->arguments    = $arguments;
        $this->container    = $container;
    }

    public function index()
    {
        return $this->render('index');
    }

    public function about()
    {
        return $this->render('about', [
            'title' => 'Description',
        ]);
    }

    public function wp2md()
    {
        $wp2md_readme = file_get_contents(App::$path . '/vendor/wpreadme2markdown/wpreadme2markdown/README.md');

        return $this->render('wp2md', [
            'readme' => \Parsedown::instance()->text($wp2md_readme),
            'title'  => 'WP2MD CLI'
        ]);
    }

    public function convert()
    {
        $readme = $this->request->getParam('readme-text');

        if (isset($_FILES['readme-file']) && $_FILES['readme-file']['error'] === UPLOAD_ERR_OK) {
            $readme = file_get_contents($_FILES['readme-file']['tmp_name']);
        }

//        if (empty($readme)) {
//            App::$slim->flashNow('error', 'Either Readme content or Readme file must be set');
//            $this->index();
//            return;
//        }

        $slug = $this->request->getParam('plugin-slug');

        if (empty(trim($slug))) {
            $slug = null;
        }

        $markdown = Converter::convert($readme, $slug);

        // also render demo
        $markdown_html = \Parsedown::instance()->text($markdown);

        return $this->render('convert', [
            'markdown' => $markdown,
            'markdown_html' => $markdown_html,
        ]);
    }

    public function download()
    {
        $markdown = $this->request->getParsedBodyParam('markdown');

        $response = $this->response->
            withHeader('Content-Type', 'application/octet-stream')->
            withHeader('Content-Transfer-Encoding', 'binary')->
            withHeader('Content-disposition', 'attachment; filename="README.md"')->
            getBody()->write($markdown);

        return $response;
    }

    private function render($template, $args = [])
    {
        return $this->container->view->render($this->response, $template, $args);
    }
}
