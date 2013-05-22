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
 * Basic Example of PHP Object Iteration with foreach
 *
 * Object iteration in PHP is over all visible properties unless
 * the object specifies it's own iteration. For example by
 * implementing Traversable.
 *
 * @link http://php.net/oop5.iterations
 */

$obj      = new stdClass;
$obj->foo = "bar";

foreach ($obj as $key => $value) {
    echo $key, ' => ', $value, "\n";
}


class MyClass
{
    public $foo = 'bar';
    protected $answer = 42;
}

$obj = new MyClass;

foreach ($obj as $key => $value) {
    echo $key, ' => ', $value, "\n";
}


class MyEach extends MyClass
{
    public function iterate()
    {
        foreach ($this as $key => $value) {
            echo $key, ' => ', $value, "\n";
        }
    }
}

$obj = new MyEach;
$obj->iterate();
