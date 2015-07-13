<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2015 hakre <http://hakre.wordpress.com/>
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
 * Class FieldIterator
 *
 * Iterates over a field (object property)
 */
class FieldIterator extends IteratorIterator
{
    /**
     * @var string
     */
    private $field;

    /**
     * @param Traversable $iterator (optional)
     * @param string      $field
     */
    public function __construct(Traversable $iterator, $field)
    {
        $this->field = $field;

        parent::__construct($iterator);
    }

    public function current()
    {
        return parent::current()->{$this->field};
    }
}
