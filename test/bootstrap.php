<?php
/*
 * Iterator Garden
 */

spl_autoload_register(function ($class) {
    $stub = pathinfo($class, PATHINFO_FILENAME);
    $path = sprintf(__DIR__ . '/%s.php', $stub);

    if (is_file($path)) {
        require($path);
    }
});

require(__DIR__ . '/../src/autoload.php');

