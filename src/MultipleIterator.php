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
 *
 * This file contains code originally licensed under Apache 2 published by
 * JetBrains with license <https://www.apache.org/licenses/LICENSE-2.0>.
 * (SPDX: Apache-2.0)
 */

/**
 * An Iterator that sequentially iterates over all attached iterators
 *
 * @link http://php.net/manual/en/class.multipleiterator.php
 */
class MultipleIterator implements Iterator
{
    /**
     * Inner Iterators
     *
     * @var SplObjectStorage|Iterator[]
     */
    private $iterators;

    /**
     * Flags: const MIT_*
     *
     * @var int
     */
    private $flags;

    const MIT_NEED_ANY     = 0; # Do not require all sub-iterators to be valid in iteration.
    const MIT_NEED_ALL     = 1; # Require all sub iterators to be valid in iteration.
    const MIT_KEYS_NUMERIC = 0; # Keys are created from the sub-iterators position.
    const MIT_KEYS_ASSOC   = 2; # Keys are created from sub iterators associated information.

    /**
     * Constructs a new MultipleIterator
     *
     * @link http://php.net/manual/en/multipleiterator.construct.php
     *
     * @param int $flags [optional] Defaults to MultipleIterator::MIT_NEED_ALL | MultipleIterator::MIT_KEYS_NUMERIC
     */
    public function __construct($flags = null)
    {
        if ($flags === null) {
            $flags = self::MIT_NEED_ALL | self::MIT_KEYS_NUMERIC;
        }

        $this->iterators = new SplObjectStorage();
        $this->flags     = $flags;
    }

    /**
     * Handle MultipleIterator clone operation
     */
    public function __clone()
    {
        $this->iterators = clone $this->iterators;
        $this->flags     = 0;
    }

    /**
     * Gets the flag information
     *
     * @link http://php.net/manual/en/multipleiterator.getflags.php
     *
     * @return int Information about the flags, as an integer.
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Sets flags
     *
     * @link http://php.net/manual/en/multipleiterator.setflags.php
     *
     * @param int $flags The flags to set, according to the Flag Constants
     *
     * @return void
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * Attaches iterator information
     *
     * @link http://php.net/manual/en/multipleiterator.attachiterator.php
     *
     * @param Iterator $iterator The new iterator to attach.
     * @param string   $info     [optional] The associative information for the Iterator, which must be an integer, a
     *                           string, or null.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function attachIterator(Iterator $iterator, $info = null)
    {
        $this->validateInfo($info);
        $this->iterators->attach($iterator, $info);
    }

    /**
     * Detaches an iterator
     *
     * @link http://php.net/manual/en/multipleiterator.detachiterator.php
     *
     * @param Iterator $iterator The iterator to detach.
     *
     * @return void
     */
    public function detachIterator(Iterator $iterator)
    {
        $this->iterators->detach($iterator);
    }

    /**
     * Checks if an iterator is attached
     *
     * @link http://php.net/manual/en/multipleiterator.containsiterator.php
     *
     * @param Iterator $iterator The iterator to check.
     *
     * @return bool true on success or false on failure.
     */
    public function containsIterator(Iterator $iterator)
    {
        return $this->iterators->contains($iterator);
    }

    /**
     * Gets the number of attached iterator instances
     *
     * @link http://php.net/manual/en/multipleiterator.countiterators.php
     *
     * @return int The number of attached iterator instances (as an integer).
     */
    public function countIterators()
    {
        return $this->iterators->count();
    }

    /**
     * @param null|int|string $info
     *
     * @return void
     */
    private function validateInfo($info)
    {
        if (null === $info) {
            return;
        }

        if (!is_int($info) && !is_string($info)) {
            throw new InvalidArgumentException('Info must be NULL, integer or string');
        }

        for ($this->iterators->rewind(); $this->iterators->valid(); $this->iterators->next()) {
            if ($info === $this->iterators->getInfo()) {
                throw new InvalidArgumentException('Key duplication error');
            }
        }
    }

    /**
     * Get an object from an SplObjectStorage by info.
     *
     * @param SplObjectStorage $storage
     * @param integer|string   $info
     *
     * @return null|object returns the object from store when found, null when not found
     */
    private function getInfo(SplObjectStorage $storage, $info)
    {
        foreach ($storage as $current) {
            if ($info === $storage->getInfo()) {
                return $current;
            }
        }

        return null;
    }

    //
    // Iterator Methods
    //

    /**
     * Rewinds all attached iterator instances
     *
     * @link http://php.net/manual/en/multipleiterator.rewind.php
     *
     * @return void
     */
    public function rewind()
    {
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
    }

    /**
     * Checks the validity of sub iterators
     *
     * @link http://php.net/manual/en/multipleiterator.valid.php
     *
     * @return bool true if one or all sub iterators are valid depending on flags, otherwise false
     */
    public function valid()
    {
        if (!$this->iterators->count()) {
            return false;
        }

        # If MIT_NEED_ALL is set all sub iterators need to be valid, otherwise return false on the first non valid one.
        # If that flag is not set return true on the first valid sub iterator found.
        $expect = self::MIT_NEED_ALL & $this->flags;
        foreach ($this->iterators as $iterator) {
            if ($expect != $iterator->valid()) {
                return !$expect;
            }
        }

        return (bool) $expect;
    }

    /**
     * Gets the registered iterator instances
     *
     * @link http://php.net/manual/en/multipleiterator.current.php
     *
     * @return array|false              An array of all registered iterator instances, or false if no sub iterator is
     *                                  attached.
     * @throws InvalidArgumentException If MIT_KEYS_ASSOC is set and there is NULL for the associative key.
     * @throws RuntimeException         If MIT_NEED_ALL is set and an attached Iterator is not valid().
     */
    public function current()
    {
        if (!$this->iterators->count()) {
            return false;
        }

        $useKeys = self::MIT_KEYS_ASSOC & $this->flags;
        $needAll = self::MIT_NEED_ALL & $this->flags;

        $return = array();

        foreach ($this->iterators as $index => $iterator) {
            $key = $useKeys ? $this->iterators->getInfo() : $index;
            if (null === $key) {
                throw new InvalidArgumentException('Sub-Iterator is associated with NULL');
            }
            $return[$key] = null;

            if ($iterator->valid()) {
                $return[$key] = $iterator->current();
            } elseif ($needAll) {
                throw new RuntimeException('Called current() with non valid sub iterator');
            }
        }

        return $return;
    }

    /**
     * Gets the registered iterator instances
     *
     * @link http://php.net/manual/en/multipleiterator.key.php
     *
     * @return array|Iterator[]|false   An array of all registered iterator instances keys, or false if no sub iterator
     *                                  is attached. If an iterator is not valid, null is guveb as key-value.
     * @throws InvalidArgumentException If MIT_KEYS_ASSOC is set and there is NULL for the associative key.
     * @throws RuntimeException         If MIT_NEED_ALL is set and an attached Iterator is not valid().
     */
    public function key()
    {
        if (!$this->iterators->count()) {
            return false;
        }

        $useKeys = self::MIT_KEYS_ASSOC & $this->flags;
        $needAll = self::MIT_NEED_ALL & $this->flags;

        $return = array();

        foreach ($this->iterators as $index => $iterator) {
            $key = $useKeys ? $this->iterators->getInfo() : $index;
            if (null === $key) {
                throw new InvalidArgumentException('Sub-Iterator is associated with NULL');
            }
            $return[$key] = null;

            if ($iterator->valid()) {
                $return[$key] = $iterator->key();
            } elseif ($needAll) {
                throw new RuntimeException('Called key() with non valid sub iterator');
            }
        }

        return $return;
    }

    /** Move all attached Iterator instances forward. That is invoke
     * their next() method regardless of their state.
     */
    public function next()
    {
        foreach ($this->iterators as $iter) {
            $iter->next();
        }
    }
}
