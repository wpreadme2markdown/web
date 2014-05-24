<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 *
 * @var string   $content
 * @var string[] $flash
 */
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WP Readme to Markdown</title>
        <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>

    <body>
        <div class="container-fluid">
            <?php if (isset($flash['error'])): ?>
                <div class="alert alert-danger">
                    <?= $flash['error'] ?>
                </div>
            <?php endif ?>

            <div class="page-header">
                <h1>WP Readme to Markdown</h1>
            </div>

            <?= $content ?>
        </div>

        <footer class="wp2md-page-footer container-fluid">
            <p>
                Copyright &copy; 2014 <a href="https://sunchaser.info/">Christian Archer</a>
                <br>
                This web application is a subject to <a href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPL v3.0</a>
            </p>
            <p>
                <a href="/">Home</a> &bull;
                About &bull; License Info &bull; GitHub &bull; BitBucket
            </p>
        </footer>

        <script src="/vendor/frameworks/jquery/jquery.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>
