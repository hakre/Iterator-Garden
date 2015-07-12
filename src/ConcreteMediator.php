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
    /**
     * PCRE pattern to validate type-names against
     *
     * This mediator normalizes names also to lower-case
     */
    const TYPE_NAME_PATTERN = '~^[a-z][a-z0-9-]*$~';

    /**
     * @var array event-map by type containing all registered callbacks by their ID
     */
    private $events;

    /**
     * @var array|callable[] ID map callables that have been added as listeners
     */
    private $register;

    /**
     * @var int counter for unique IDs
     */
    private $regId = 0;

    private $type;

    /**
     * @param string   $type
     * @param callable $callable
     *
     * @throws InvalidArgumentException
     */
    public function addListener($type, $callable)
    {
        $type = $this->validateTypeName($type);
        $this->validateCallable($callable);

        $id                       = ++$this->regId;
        $this->register[$id]      = $callable;
        $this->events[$type][$id] = $id;
    }

    private function validateCallable($callable)
    {
        $callableName = null;
        $valid        = null;

        if (
            is_array($callable)
            && (
                count($callable) !== 2
                || !in_array(gettype($callable[0]), array('object', 'string'))
            )
        ) {
            $valid        = false;
            $callableName = "Array";
        } else {
            $valid = is_callable($callable, true, $callableName);
        }

        if (!$valid) {
            throw new InvalidArgumentException(sprintf("invalid callback syntax '%s'", $callableName));
        }
    }

    /**
     * @param string $type
     * @param array  $arguments
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

            if (!is_callable($callback, false, $callableName)) {
                throw new InvalidArgumentException(sprintf("callback is not callable '%s'", $callableName));
            }

            call_user_func($callback, $this, $arguments);
        }

    }

    /**
     * @param string $type
     *
     * @return string normalized type-name
     */
    private function validateTypeName($type)
    {
        if (is_array($type) || is_object($type) && !method_exists($type, '__toString')) {
            throw new InvalidArgumentException(sprintf('event type can not be an array or object'));
        }

        $name = strtolower(trim($type));
        if (!preg_match(self::TYPE_NAME_PATTERN, $name)) {
            throw new InvalidArgumentException(sprintf("invalid event type name '%s'", $name));
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
