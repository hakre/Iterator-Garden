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
 * Iterators shipping with the current PHP Setup
 *
 * This example generates a markdown document listing all classes extending from Traversable for the current
 * PHP configuration.
 *
 * Needs PHP 5.5 or above.
 */

require 'IterUtil.php';

$classes               = PhpClass::map(get_declared_classes());
$traversableSubClasses = IterUtil::getCoreTraversableSubclasses();

$getCoreTraversableInfoString = function ($class) use ($traversableSubClasses) {
    $class = PhpClass::validate($class);

    $subclasses = $class->getSubclassesFrom($traversableSubClasses);

    return $subclasses ? ' (' . implode(', ', $subclasses) . ')' : '';
};

$traversable = new PhpClass('Traversable');

$grouping = array(array(), array('Core' => null, 'SPL' => null));

foreach ($classes as $class) {
    $isTraversable = $class->isSubclassOf($traversable);
    if (!$isTraversable) {
        continue;
    }

    $extension = $class->getExtensionName();

    $group = (bool) in_array($extension, array('Core', 'SPL'));
    $grouping[$group][$extension][] = $class;
}

ksort($grouping[0], SORT_STRING | SORT_FLAG_CASE);

$groupingByExtensionCreate = function() use ($grouping) {
    foreach($grouping as $group) {

        foreach($group as $extension => $classes) {
            sort($classes, SORT_STRING | SORT_FLAG_CASE);
            yield $extension => $classes;
        }
    }
};

$groupingByExtension = $groupingByExtensionCreate();

include 'template.md.php';
