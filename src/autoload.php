<?php
/**
 * Iterator Garden
 */

spl_autoload_register(function ($class) {
    static $classMap = array(
        'DebugIterator'         => 'Debug/DebugIterator',
        'MagicDebugIterator'    => 'Debug/MagicDebugIterator',
        'SeekableDebugIterator' => 'Debug/SeekableDebugIterator',
    );

    $stub = isset($classMap[$class]) ? $classMap[$class] : pathinfo($class, PATHINFO_FILENAME);

    $path = sprintf(__DIR__ . '/%s.php', $stub);

    if (is_file($path)) {
        require($path);
    }
});
