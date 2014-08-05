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

abstract class ForeachIteratorBaseTest extends IteratorTestCase
{
    public function provideForeachAbleSamples()
    {
        return array(
            // NULL
            array(null, false),
            // array
            array(array(), true),
            // object
            array(new stdClass, true),
            // Traversable
            array(simplexml_load_string('<r><e/><e/><e/><e/></r>'), true),
            // Iterator
            array(new ArrayIterator(array()), true),
            // IteratorAggregate
            array(new ArrayObject(array()), true),
        );
    }

    /**
     * test constructor with valid/invalid foreachable samples
     *
     * @param string $className
     * @param mixed  $foreachAble
     * @param bool   $valid
     *
     * @throws Exception
     */
    protected function helperTestConstructor($className, $foreachAble, $valid)
    {
        try {
            $subject = new $className($foreachAble);
        } catch (Exception $e) {
            $this->addToAssertionCount(1);
            if ($valid) {
                throw $e;
            }
            return;
        }
        $this->assertInstanceOf($className, $subject);
    }
}


