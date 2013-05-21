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
 * Class MagicDebugIterator
 *
 * A MagicDebugIterator that also shows access to unset properties (__get()) and method
 * calls to undefined methods (__call()).
 */
class MagicDebugIterator extends DebugIterator
{
    public function __get($name)
    {
        $this->event(sprintf('__get(%s)'), $name);
    }

    public function __call($name, $arguments)
    {
        $this->event(sprintf('__call(%s, [%s])'), $this->args($name), $this->args($arguments));
    }

    private function args($args)
    {
        if (is_array($args)) {
            return implode(', ', array_map(array($this, __FUNCTION__), $args));
        }

        return $this->varLabel($args);
    }
}
