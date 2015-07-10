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
 * @covers RecursiveDecoratingIterator
 */
class RecursiveDecoratingIteratorTest extends IteratorTestCase
{

    /**
     * private helper method for tests
     *
     * @param array|Traversable $traversable
     * @param string|Callable $decorator
     * @param int $mode
     * @return RecursiveDecoratingIterator
     */
    private function createSubject($traversable = NULL, $decorator = NULL, $mode = NULL)
    {
        if ($traversable === NULL) {
            $traversable = array('1.' => array('a' => 'Entry 1.a)', 'b' => 'Entry 1.b)'));
        }

        if (is_array($traversable)) {
            $traversable = new RecursiveArrayIterator($traversable);
        }

        if ($decorator === NULL) {
            $decorator = function ($current) {
                return "[$current]";
            };
        }

        return new RecursiveDecoratingIterator($traversable, $decorator, $mode);
    }

    public function testConstructor()
    {
        $it = $this->createSubject();
        $this->assertInstanceOf('RecursiveDecoratingIterator', $it);

    }

    public function testRecursiveIterator()
    {
        $it = $this->createSubject();
        $this->assertInstanceOf('RecursiveIterator', $it);
    }

    public function testDecoration()
    {
        $array    = array(array(1 => '0.1.'));
        $expected = $array + array(1 => '[0.1.]');

        $it     = $this->createSubject($array);
        $rit    = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        $actual = iterator_to_array($rit);

        $this->assertSame($expected, $actual);
    }

    public function testDecorationOnLeafsOnly()
    {
        $array = array(array(1 => '0.1.', 2 => '0.2.'));
        $assertions = $this;

        $it = $this->createSubject($array, function ($leaf) use ($assertions) {
            $assertions->addToAssertionCount(1);
            $assertions->assertInternalType('string', $leaf, 'Leaf is a string');
            return $leaf;
        });

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals(2, $assertions->getNumAssertions());
    }

    public function testDecorationOnChildrenOnly()
    {
        $assertions = $this;

        $it = $this->createSubject(NULL, function ($children) use ($assertions) {
            $assertions->addToAssertionCount(1);
            $assertions->assertInternalType('array', $children, 'Children are array');
            return $children;
        }, RecursiveDecoratingIterator::DECORATE_CHILDREN);

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals(1, $assertions->getNumAssertions());
    }

    public function testDecorationOnChildrenAndLeafs()
    {
        $array = array(1 => array(1, 2), 2 => array(3,4), 3 => array(5));
        $count = array(0, 0);
        $assertions = $this;

        $it = $this->createSubject($array, function ($childrenOrLeaf) use (&$rit, &$count, $assertions) {
                /** @var RecursiveIteratorIterator $rit */
                $children = $rit->getSubIterator()->hasChildren();
                $expected = $children ? 'array' : 'int';
                $assertions->assertInternalType($expected, $childrenOrLeaf, 'Correct Type');
                $count[$children]++;
                return $childrenOrLeaf;
            }, RecursiveDecoratingIterator::DECORATE_NODES);

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals(array(5, 3), $count);
    }
}
