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
 * Iterator Garden php-iterators example
 */

require_once 'PhpClass.php';

/**
 * Class IterUtil
 */
final class IterUtil
{
    /**
     * @return array
     */
    public static function getTraversableSubclasses() {

    }

    /**
     * all PHP core class that are Traversable excl. Traversable
     *
     * @return array|\PhpClass[]
     */
    public static function getCoreTraversableSubclasses() {
        $traversableSubClasses = array('Iterator', 'IteratorIterator', 'IteratorAggregate');

        $generatorClass = 'Generator';
        if (class_exists($generatorClass, false)) {
            $traversableSubClasses[] = $generatorClass;
        }

        return PhpClass::map($traversableSubClasses);
    }
}
