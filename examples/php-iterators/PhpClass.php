<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 1014 hakre <http://hakre.wordpress.com/>
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
 * Class PhpClass
 */
class PhpClass
{
    const CORE_EXTENSION_NAME = 'Core';

    private $name;

    static function validate($class) {
        if (is_string($class)) {
            $class = new self($class);
        }

        if (! ($class instanceof self)) {
            $class = new self($class);
        }

        $name = $class->getName();

        if (!$class->isDefined()) {
            throw new InvalidArgumentException(sprintf("Required argument %s is not a defined class", var_export($name, true)));
        }

        return $class;
    }

    /**
     * @param $mixed
     *
     * @return PhpClass|PhpClass[]
     */
    static function map($mixed) {
        if ($mixed instanceof self) {
            return $mixed;
        }
        if (is_string($mixed)) {
            return new PhpClass($mixed);
        }

        $result = array();
        foreach ($mixed as $class) {
            $result[] = PhpClass::map($class);
        }

        return $result;
    }

    function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    function isDefined() {
        return class_exists($this->name, false);
    }

    function isSubclassOf($class) {
        if ($class instanceof self) {
            $class = $class->name;
        }
        return is_subclass_of($this->name, $class);
    }

    /**
     * @param mixed $subclasses to look for
     *
     * @return PhpClass[]
     */
    function getSubclassesFrom($subclasses)
    {
        $result = array();

        foreach ($subclasses as $subclass) {
            $hasSubclass = $this->isSubclassOf($subclass);
            if ($hasSubclass) {
                $result[] = PhpClass::map($subclass);
            }
        }

        return $result;
    }

    /**
     * @return ReflectionClass
     */
    function getReflectionClass() {
        return new ReflectionClass($this->name);
    }

    function isUserDefined() {
        return $this->getReflectionClass()->isUserDefined();
    }

    function isCore() {
        return $this->getExtensionName() === self::CORE_EXTENSION_NAME;
    }

    function getExtensionName() {
        return $this->getReflectionClass()->getExtensionName();
    }

    function __toString() {
        return $this->name;
    }
}
