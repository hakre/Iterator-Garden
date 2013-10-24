<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2014, 2015 hakre <http://hakre.wordpress.com/>
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
 * Class DOMElementFilter
 *
 * FilterIterator that checks for DOMElement instance and optionally as well
 * for the tag-name of the element.
 */
class DOMElementFilter extends FilterIterator
{
    private $tagName;

    public function __construct(Traversable $traversable, $tagName = NULL)
    {
        if ($traversable instanceof Iterator) {
            $iterator = $traversable;
        } else {
            $iterator = new IteratorIterator($traversable);
        }

        $this->tagName = $tagName;
        parent::__construct($iterator);
    }

    /**
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept()
    {
        $current = $this->getInnerIterator()->current();

        if (!$current instanceof DOMElement) {
            return FALSE;
        }

        return $this->tagName === NULL || $current->tagName === $this->tagName;
    }
}
