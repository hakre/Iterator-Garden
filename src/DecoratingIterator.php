<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014 hakre <http://hakre.wordpress.com/>
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
 * Class DecoratingIterator
 *
 * @author Marcus Börger (2008)
 * @link https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
 * @example http://stackoverflow.com/a/16998550/367456
 */
class DecoratingIterator extends IteratorIterator
{
    private $decorator;

    function __construct(Traversable $iterator, $decorator)
    {
        $this->decorator = $decorator;
        parent::__construct($iterator);
    }

    function current()
    {
        if (is_callable($this->decorator)) {
            return call_user_func($this->decorator, parent::current());
        } elseif (class_exists($this->decorator)) {
            return new $this->decorator(parent::current());
        } else {
            throw new Exception('Not a valid decorator: ' . var_export($this->decorator, TRUE));
        }
    }
}
