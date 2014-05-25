<?php

/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace SunChaser\com\wpreadme2markdown;

class View extends \Slim\View
{
    protected function render($template, $data = [])
    {
        $template .= '.phtml';

        $data['content'] = parent::render($template, $data);

        return parent::render('layout.phtml', $data);
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
