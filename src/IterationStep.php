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
 * Class IterationStep
 *
 * Represents a single iteration in an iteration.
 */
class IterationStep
{
    private $current, $key, $valid;

    public function __construct($valid, $current, $key)
    {
        $this->valid   = $valid;
        $this->current = $current;
        $this->key     = $key;
    }

    public static function createFromIterator(Iterator $iterator)
    {
        $valid = NULL;

        try {
            $valid = $iterator->valid();
        } catch (Exception $e) {
        }

        if (!$valid) {
            return new self($valid, NULL, NULL);
        }

        return new self(
            $valid,
            $iterator->current(),
            $iterator->key()
        );
    }

    public static function createFromArray(array &$array) {
        $key   = key($array);
        $valid = $key !== NULL;

        return new self(
            $valid,
            $valid ? current($array) : $key,
            $key
        );
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValid()
    {
        return $this->valid;
    }
}
