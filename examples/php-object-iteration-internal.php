<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013 hakre <http://hakre.wordpress.com/>
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
 * Basic Example of PHP Object Iteration with foreach over an internal object
 *
 * Internal objects can define their own iteration without being a Traversable
 * at all. This allows them to break with the behavior outlined in the
 * PHP manual
 *
 * @link http://php.net/oop5.iterations
 */

$object = new mysqli_driver;

printf("# Exemplary internal object iteration of `%s`:", get_class($object));

echo "\n\n## Default PHP Object Property Iteration:\n\n";
foreach ($object as $property => $value) {
    printf("    %'.-20s: %s  \n", $property, var_export($value, TRUE));
}

echo "\n\n## Accessing Properties in the Iteration:\n\n";
foreach ($object as $property => $value) {
    printf("    %'.-20s: %s  \n", $property, var_export($object->$property, TRUE));
}
