<?php

/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace WPReadme2Markdown\Web;

use Slim\Views\PhpRenderer;

class View extends PhpRenderer
{
    public function fetch($template, $data = [])
    {
        $template .= '.phtml';

        $data['content'] = parent::fetch($template, $data);

        return parent::fetch('layout.phtml', $data);
    }

    protected function counters()
    {
        $file = App::$path . '/counters.html';
        if (file_exists($file)) {
            return file_get_contents($file);
        }

        return '';
    }
}
