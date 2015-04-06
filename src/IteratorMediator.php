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
 * Class IteratorMediator
 *
 * An Iterator which is at the same time as well a Mediator emitting iteration events
 */
class IteratorMediator extends IteratorDecorator implements Mediator
{
    /**
     * @var Mediator
     */
    protected $mediator;

    public function __construct(Iterator $iterator = NULL, Mediator $mediator = NULL)
    {
        $iterator || $iterator = new EmptyIterator();

        parent::__construct($iterator);

        $this->mediator = $mediator ?: new ConcreteMediator();
    }

    /**
     * @param string $type
     * @param callable $callable
     * @return void
     */
    public function addListener($type, $callable)
    {
        $this->mediator->addListener($type, $callable);
    }

    /**
     * @param string $type
     * @param array $arguments
     * @return void
     */
    public function notify($type, array $arguments = array())
    {
        $this->mediator->notify($type, $arguments);
    }

    public function rewind()
    {
        parent::rewind();
        $this->mediator->notify(__FUNCTION__);
    }

    public function valid()
    {
        $valid = parent::valid();
        $this->mediator->notify(__FUNCTION__, array($valid));
        return $valid;
    }

    public function current()
    {
        $current = parent::current();
        $this->mediator->notify(__FUNCTION__, array($current));
        return $current;
    }

    public function key()
    {
        $key = parent::key();
        $this->mediator->notify(__FUNCTION__, array($key));
        return $key;
    }

    public function next()
    {
        parent::next();
        $this->mediator->notify(__FUNCTION__);
    }
}
