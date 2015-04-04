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
 * Class DOMNodeIterator
 *
 * Iterate DOMNodes in document order
 */
class DOMNodeIterator implements Iterator
{
    /**
     * @var DOMNode
     */
    private $node;

    /**
     * @var DOMNode
     */
    private $current;

    /**
     * @var int
     */
    private $index;

    function __construct(DOMNode $node)
    {
        $this->node = $node;
    }

    public function rewind()
    {
        $this->index   = 0;
        $this->current = $this->node;
    }

    public function valid()
    {
        return (bool)$this->current;
    }

    /**
     * @return DOMNode
     */
    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $current = $this->current;

        if (!$current) {
            return;
        }

        $this->current = $this->dom_node_next($current);

        if ($this->current) {
            $this->index++;
        } else {
            $this->index = NULL;
        }
    }

    /**
     * @param DOMNode $node
     * @return DOMNode|null next node in document order or null in case there is no next node
     */
    private function dom_node_next(DOMNode $node)
    {
        if ($node->firstChild) {
            return $node->firstChild;
        }

        do {
            if ($node->nextSibling) {
                return $node->nextSibling;
            }
        } while ($node = $node->parentNode);

        return NULL;
    }
}
