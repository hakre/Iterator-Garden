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
 * Class BaseMediator
 */
class ConcreteMediator implements Mediator
{
    private $events;
    private $register;
    private $regId = 0;

    private $type;

    /**
     * @param string $type
     * @param callable $callable
     *
     * @throws InvalidArgumentException
     */
    public function addListener($type, $callable)
    {
        $type = $this->validateTypeName($type);

        if (!is_callable($callable, TRUE, $callableName)) {
            throw new InvalidArgumentException(sprintf("invalid callback syntax '%s'", $callableName));
        }

        $id                       = ++$this->regId;
        $this->register[$id]      = $callable;
        $this->events[$type][$id] = $id;
    }

    /**
     * @param string $type
     * @param array $arguments
     *
     * @throws InvalidArgumentException
     */
    public function notify($type, array $arguments = array())
    {
        $type = $this->validateTypeName($type);

        $this->type = $type;

        if (!isset($this->events[$type])) {
            return;
        }

        foreach ($this->events[$type] as $id) {

            $callback = $this->register[$id];

            if (!is_callable($callback, FALSE, $callableName)) {
                throw new InvalidArgumentException(sprintf("callback is not callable '%s'", $callableName));
            }

            call_user_func($callback, $this, $arguments);
        }

    }

    /**
     * @param string $type
     * @return string normalized type-name
     */
    private function validateTypeName($type)
    {
        if (is_array($type)) {
            throw new InvalidArgumentException(sprintf('event type can not be array'));
        } elseif (is_object($type)) {
            $name = get_class($type);
        } else {
            $name = (string)$type;
        }

        $name = strtolower(trim($name));
        if (!preg_match('~^[a-z]+$~', $name)) {
            throw new InvalidArgumentException(sprintf("invalid event type name '%s'", $type));
        }

        return $name;
    }

    /**
     * @return string normalized type name of the current event
     */
    public function getType()
    {
        return $this->type;
    }
}
