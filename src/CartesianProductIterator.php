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
 * Class CartesianProductIterator
 *
 * Create a Cartesian Product of zero or more iterators (normally two or more iterators)
 */
class CartesianProductIterator implements Iterator
{
    /**
     * Iterate the last Iterator first (default)
     */
    const ORDER_LAST_FIRST = 1;

    /**
     * Iterate the first Iterator first
     */
    const ORDER_FIRST_FIRST = 2;

    /**
     * @var array|Iterator[]
     */
    private $iterators = [];

    /**
     * @var array|int[]
     */
    private $countOrders = [];

    /**
     * @var array|int[]|string[]
     */
    private $orderedIteratorKeys = [];

    private $sortMode;

    public function __construct($orderMode = NULL)
    {
        $this->setOrderMode($orderMode);
    }

    /**
     * @param Iterator $iterator to append
     * @param int $countOrder (optional) weight to order for $iterator relative to the other iterators in the product
     */
    public function append(Iterator $iterator, $countOrder = NULL)
    {
        $index                   = count($this->iterators);
        $this->iterators[$index] = $iterator;
        if ($countOrder === NULL) {
            $countOrder = $index;
        }
        $this->countOrders[$index] = $countOrder;

        $iteratorKeys = array_keys($this->iterators);
        $countOrders  = $this->countOrders;
        array_multisort($countOrders, $this->sortMode, $iteratorKeys);

        $this->orderedIteratorKeys = $iteratorKeys;
    }

    public function getArrayIterator()
    {
        return new ArrayIterator($this->iterators);
    }

    public function rewind()
    {
        $this->map('rewind');
        $this->index = 0;
    }

    public function valid()
    {
        if (!$this->iterators) {
            return FALSE;
        }

        foreach ($this->iterators as $iterator) {
            if (!$iterator->valid()) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function current()
    {
        return $this->map('current');
    }

    public function key()
    {
        return $this->map('key');
    }

    public function next()
    {
        $rewindKeys = array();

        foreach ($this->orderedIteratorKeys as $key) {
            $iterator = $this->iterators[$key];
            $iterator->next();
            if ($iterator->valid()) {
                $this->rewindByKeys($rewindKeys);
                break;
            }
            $rewindKeys[] = $key;
        }
    }

    private function rewindByKeys(array $keys)
    {
        foreach ($keys as $key) {
            $this->iterators[$key]->rewind();
        }
    }

    /**
     * @param int|null $order (optional)mode
     */
    private function setOrderMode($order = NULL)
    {
        switch ($order) {
            case NULL:
            case self::ORDER_LAST_FIRST:
                $sortMode = SORT_DESC;
                break;

            case self::ORDER_FIRST_FIRST:
                $sortMode = SORT_ASC;
                break;

            default:
                throw new InvalidArgumentException(sprintf("Invalid order: %s", var_export($order, TRUE)));
        }

        $this->sortMode = $sortMode;
    }

    private function map($method)
    {
        return array_map(function (Iterator $iterator) use ($method) {
            return $iterator->$method();
        }, $this->iterators);
    }
}
