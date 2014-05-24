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
        $template .= '.php';

        $data['content'] = parent::render($template, $data);

        return parent::render('layout.php', $data);
    }
}
