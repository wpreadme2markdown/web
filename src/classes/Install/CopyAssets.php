<?php

declare(strict_types=1);

namespace WPReadme2Markdown\Web\Install;

use Symfony\Component\Filesystem\Filesystem;

abstract class CopyAssets
{
    private static array $files = [
        'twbs/bootstrap/dist/css/bootstrap.min.css',
        'frameworks/jquery/jquery.min.js',
        'twbs/bootstrap/dist/js/bootstrap.min.js',
    ];

    public static function postInstall()
    {
        $rootPath   = realpath(__DIR__ . '/../../..');
        $vendorPath = $rootPath . '/vendor';
        $assetsPath = $rootPath . '/assets/vendor';

        $filesystem = new Filesystem();

        foreach (self::$files as $file) {
            $src = $vendorPath . '/' . $file;
            $dst = $assetsPath . '/' . basename($file);

            $filesystem->copy($src, $dst, true);
        }
    }
}
