<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */

namespace SunChaser\com\wpreadme2markdown;

use Slim\Middleware\SessionCookie;
use Slim\Slim;

class App
{
    /**
     * @var \Slim\Slim
     */
    public static $slim;
    public static $path;

    public static function run($path)
    {
        self::$path = $path;
        self::$slim = $slim = new Slim([
            'templates.path' => $path . '/src/templates',
            'view' => View::class,
            'debug' => false,
        ]);

        $slim->add(new SessionCookie(array(
            'expires' => '20 minutes',
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => false,
            'name' => 'slim_session',
            'secret' => sha1(__FILE__ . php_uname()),
            'cipher' => MCRYPT_RIJNDAEL_256,
            'cipher_mode' => MCRYPT_MODE_CBC
        )));

        $slim->get('/', function() {
            (new Controller)->index();
        });

        $slim->post('/', function() {
            (new Controller)->convert();
        });

        $slim->post('/download', function () {
            (new Controller)->download();
        });

        $slim->get('/about', function () {
            (new Controller)->about();
        });

        $slim->get('/wp2md', function () {
            (new Controller)->wp2md();
        });

        $slim->run();
    }
}
