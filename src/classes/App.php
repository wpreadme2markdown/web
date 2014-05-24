<?php
/**
 * @author Christian Archer
 * @license AGPL-3.0
 */

namespace SunChaser\com\wpreadme2markdown;

use Slim\Slim;

class App
{
    public static $app;

    public static function run()
    {
        self::$app = $app = new Slim();
    }
}
