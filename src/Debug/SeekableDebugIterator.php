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
 * Class SeekableDebugIterator
 *
 * A DebugIterator that shows seekable events.
 */
class SeekableDebugIterator extends DebugIterator implements SeekableIterator
{
    private $innerSeekableIterator;

    public function __construct(SeekableIterator $it)
    {
        parent::__construct($it);
    }

    public function current() {
        $this->event(__FUNCTION__ . '()');
        $current = $this->traversable->current();
        $this->event(sprintf('self::$innerSeekableIterator->current() is %s', self::debugVarLabel($current)));
        return $current;
    }

    public function key() {
        $this->event(__FUNCTION__ . '()');
        $key = $this->traversable->key();
        $this->event(sprintf('self::$innerSeekableIterator->key() is %s', self::debugVarLabel($key)));
        return $key;

    }

    public function seek($position) {
        $this->event(sprintf('%s(%d)', __FUNCTION__, $position));
        $this->traversable->seek($position);
    }
}
