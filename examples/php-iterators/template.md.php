<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 1014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Markdown Template
 */

/* @var Generator $groupingByExtension */

$link = function($path) {
    return sprintf('http://php.net/%s', $path);
};

$hrefClass = function($class) use ($link) {
    return $link("class.$class");
};

$manualLink = function ($class) use ($hrefClass) {
    echo "[$class]({$hrefClass($class)})";
};

$fetched = function($href) {
    $file = __DIR__ . '/fetched/' . md5($href) . '-' . basename($href);
    if (is_readable($file)) {
        return file_get_contents($file);
    }

    $buffer = file_get_contents($href);
    if (false !== $buffer) {
        file_put_contents($file, $buffer);
    }
    return $buffer;
};

$htmlDoc = function($href) use ($fetched) {
    $doc = new DOMDocument();
    $save = libxml_use_internal_errors(true);
    $doc->loadHTML($fetched($href));
    libxml_use_internal_errors($save);
    $xp = new DOMXPath($doc);
    $doc->xp = $xp;
    return $doc;
};

$bookLink = function ($class) use ($link, $hrefClass, $htmlDoc) {
    static $undocumentedClasses = [
        'stdClass' => ['Predefined Classes', 'reserved.classes'],
        '__PHP_Incomplete_Class' => ['Predefined Classes', 'reserved.classes'],
        'XMLWriter' => ['XMLWriter', 'book.xmlwriter'],
        'finfo' => ['File Information', 'book.fileinfo'],
    ];

    if (isset($undocumentedClasses[(string) $class])) {
        list($title, $short) = $undocumentedClasses[(string) $class];
        return sprintf("[%s](%s)", $title, $link($short));
    }

    $doc = $htmlDoc($hrefClass($class));
    $a = $doc->xp->evaluate('(//aside)[1]//li/a[1]')->item(0);
    if (!$a) {
        var_dump($class); die();
    }
    return "[{$a->textContent}]({$link(basename($a->getAttribute('href'),'.php'))})";
};

$enabledExtensions = function() use ($classes, $bookLink) {
    $classesByExtension = [];
    foreach ($classes as $class) {
        $extension = $class->getExtensionName();
        $classesByExtension[$extension][] = $class;
    }
    foreach ($classesByExtension as &$classes) {
        sort($classes, SORT_STRING | SORT_FLAG_CASE);
    }

    $extensions = [];
    $loaded = array_merge(get_loaded_extensions(), get_loaded_extensions(true));
    sort($loaded, SORT_STRING | SORT_FLAG_CASE);
    foreach($loaded as $extension) {
        $hasClasses = isset($classesByExtension[$extension]);
        if (!$hasClasses) {
            $extensions[$extension] = $extension;
        }
        if (isset($extensions[$extension]))
        {
            continue;
        }
        $class = $classesByExtension[$extension][0];
        $extensions[$extension] = "$extension ({$bookLink($class)})";
    }

    return wordwrap(implode(', ', $extensions), 120);
}

?>
# List of Traversables in PHP

List of PHP classes that are <?= $manualLink('Traversable') ?>, grouped by their extension ordered A-Z
with the exception that Core and SPL are at the very end of the list.

Behind every classname there is also a list of the implemented core classes/interface that are related to iteration (if
those are additional to Traversable).

<?php foreach ($groupingByExtension as $extension => $classes) { ?>
## <?= $bookLink($classes[0]) ?> (<?= $extension ?>)

<?php foreach ($classes as $class) { ?>
- <?= $manualLink($class) ?><?= $getCoreTraversableInfoString($class) ?>

<?php } ?>

<?php } ?>

----

This document covers PHP version <?= PHP_VERSION ?> with the following extensions enabled (those
having at least one class - even if undocumented - are linked):

<?= $enabledExtensions() ?>

