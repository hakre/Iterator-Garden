<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014, 2015 hakre <http://hakre.wordpress.com/>
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
 * Class StringMatcherIteration
 */
class StringMatcherIterator implements Iterator
{
    /**
     * @var PregStringMatcher
     */
    private $matcher;

    private $subject;

    private $offset;

    private $current;
    private $key;

    /**
     * @param StringMatcher $matcher
     * @param string        $subject
     */
    public function __construct(StringMatcher $matcher, $subject)
    {
        $this->matcher = $matcher;
        $this->subject = $subject;
    }

    public function rewind()
    {
        $this->offset = 0;
        $this->fetch();
    }

    private function fetch()
    {
        $matcher = $this->matcher;

        $this->current = $matcher->match($this->subject, $offset = $this->offset);
        $this->key     = $matcher->getOffset();

        if (null === $this->offset = $this->key) {
            return;
        }

        $len = strlen($this->current);
        $this->offset += $len;

        if (0 === $len && $offset === $this->offset) {
            throw new RuntimeException(sprintf("Zero-length match at same offset"));
        }
    }

    public function valid()
    {
        return $this->key !== null;
    }

    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        if ($this->key !== null) {
            $this->fetch();
        }
    }
}
