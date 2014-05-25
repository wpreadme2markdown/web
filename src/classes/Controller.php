<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace SunChaser\com\wpreadme2markdown;

use SunChaser\WP2MD\Converter;

class Controller
{
    public function index()
    {
        App::$slim->render('index');
    }

    public function convert()
    {
        $readme = App::$slim->request->params('readme-text');

        if (isset($_FILES['readme-file']) && $_FILES['readme-file']['error'] === UPLOAD_ERR_OK) {
            $readme = file_get_contents($_FILES['readme-file']['tmp_name']);
        }

        if (empty($readme)) {
            App::$slim->flash('error', 'Either Readme content or Readme file must be set');
            $this->index();
            return;
        }

        $slug = App::$slim->request->params('plugin-slug');

        if (empty(trim($slug))) {
            $slug = null;
        }

        $markdown = Converter::convert($readme, $slug);

        // also render demo
        $markdown_html = \Parsedown::instance()->text($markdown);

        App::$slim->render('convert', [
            'markdown' => $markdown,
            'markdown_html' => $markdown_html,
        ]);
    }

    public function download()
    {
        $markdown = App::$slim->request->post('markdown');

        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="README.md"');

        echo $markdown;

        exit;
    }
}
