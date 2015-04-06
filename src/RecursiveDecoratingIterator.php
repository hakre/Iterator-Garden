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
 * Class RecursiveDecoratingIterator
 */
class RecursiveDecoratingIterator extends DecoratingIterator implements RecursiveIterator
{
    private $decorator;

    const DECORATE_NONE     = 0;
    const DECORATE_LEAFS    = 1;
    const DECORATE_CHILDREN = 2;
    const DECORATE_NODES    = 3;

    private $mode;

    function __construct(Traversable $iterator, $decorator, $mode = self::DECORATE_LEAFS)
    {
        parent::__construct($iterator, $decorator);

        $this->decorator = $decorator;

        $this->mode = $mode === NULL ? self::DECORATE_LEAFS : $mode;
    }

    public function current()
    {
        $mode = $this->mode;
        $leaf = !$this->hasChildren();
        if (
            ($leaf and ($mode & self::DECORATE_LEAFS))
            or (!$leaf and $mode & self::DECORATE_CHILDREN)
        ) {
            return parent::current();
        }

        return $this->getInnerIterator()->current();
    }

    public function hasChildren()
    {
        return $this->getInnerIterator()->hasChildren();
    }

    public function getChildren()
    {
        return new self($this->getInnerIterator()->getChildren(), $this->decorator, $this->mode);
    }
}
