<?php
/**
 * Iterator Garden
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
            $traversable = ['1.' => ['a' => 'Entry 1.a)', 'b' => 'Entry 1.b)']];
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
        $array    = [[1 => '0.1.']];
        $expected = $array + [1 => '[0.1.]'];

        $it     = $this->createSubject($array);
        $rit    = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        $actual = iterator_to_array($rit);

        $this->assertSame($expected, $actual);
    }

    public function testDecorationOnLeafsOnly()
    {
        $array = [[1 => '0.1.', 2 => '0.2.']];
        $count = 0;

        $it = $this->createSubject($array, function ($leaf) use (&$count) {
            $count++;
            $this->assertInternalType('string', $leaf, 'Leaf is a string');
            return $leaf;
        });

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals(2, $count);
    }

    public function testDecorationOnChildrenOnly()
    {
        $count = 0;

        $it = $this->createSubject(NULL, function ($children) use (&$count) {
            $count++;
            $this->assertInternalType('array', $children, 'Children are array');
            return $children;
        }, RecursiveDecoratingIterator::DECORATE_CHILDREN);

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals(1, $count);
    }

    public function testDecorationOnChildrenAndLeafs()
    {
        $array = [1 => [1, 2], 2 => [3,4], 3 => [5]];
        $count = [0, 0];

        $it = $this->createSubject($array, function ($childrenOrLeaf) use (&$rit, &$count) {
                /** @var RecursiveIteratorIterator $rit */
                $children = $rit->getSubIterator()->hasChildren();
                $expected = $children ? 'array' : 'int';
                $this->assertInternalType($expected, $childrenOrLeaf, 'Correct Type');
                $count[$children]++;
                return $childrenOrLeaf;
            }, RecursiveDecoratingIterator::DECORATE_NODES);

        $rit = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
        iterator_to_array($rit);
        $this->assertEquals([5, 3], $count);
    }
}
