<?php
/**
 * @author Christian Archer
 * @copyright 2014, Christian Archer
 * @license AGPL-3.0
 */
?>

<form action="/" method="post" enctype="multipart/form-data">
    <h4>Input or upload your WordPress Plugin Readme.txt</h4>

    <div class="form-group">
        <label for="readme-text">Readme content</label>
        <textarea id="readme-text" name="readme-text" class="form-control" rows="10" placeholder="Plugin Readme.txt content"></textarea>
    </div>

    OR

    <div class="form-group">
        <label for="readme-file">Readme file</label>
        <input id="readme-file" name="readme-file" type="file">
    </div>

    <div class="form-group">
        <label for="plugin-slug">Plugin Slug (Leave blank to autodetect)</label>
        <input id="plugin-slug" name="plugin-slug" type="text" placeholder="my-plugin-slug" class="form-control">
    </div>

    <input type="submit" value="Convert" class="btn btn-primary pull-right">
</form>
