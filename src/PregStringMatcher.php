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
 * Class PregMatcher
 */
class PregStringMatcher implements StringMatcher
{
    private $pattern;
    private $offset;
    private $matches;
    private $result;

    function __construct($pattern)
    {
        if (FALSE === preg_match($pattern, "")) {
            throw new InvalidArgumentException(sprintf('Invalid pattern %s', var_export($pattern, TRUE)));
        }
        $this->pattern = $pattern;
    }

    /**
     * @param $string
     * @param int $offset
     * @return string|null
     */
    public function match($string, $offset = 0)
    {
        if ($this->result = preg_match($this->pattern, $string, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $this->offset  = $matches[0][1];
            $this->matches = $matches;
            return $matches[0][0];
        } else {
            $this->offset  = NULL;
            $this->matches = NULL;
            return NULL;
        }
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int|string $index (optional) use string for named groups
     *
     * @return string|null
     */
    public function getMatch($index = NULL)
    {
        if ($index === NULL) {
            $index = 0;
        }
        if (!isset($this->matches[$index])) {
            return NULL;
        }
        return $this->matches[$index][0];
    }
}
