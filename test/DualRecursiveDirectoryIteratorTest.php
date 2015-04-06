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
 * Class DualRecursiveDirectoryIteratorTest
 *
 * @covers DualRecursiveDirectoryIterator
 */
class DualRecursiveDirectoryIteratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getSubPathname()
    {
        $dual = new DualRecursiveDirectoryIterator(__DIR__, __DIR__ . '/../src');

        /** @var RecursiveIteratorIterator|DualRecursiveDirectoryIterator $it */
        $it = new RecursiveIteratorIterator($dual);
        foreach ($it as $file) {
            if ($it->getSubPath() !== 'Debug') {
                continue;
            }
            $this->assertGreaterThan(0, strlen($file));

            $this->addToAssertionCount(1);
            $this->assertEquals('Debug', $dual->getSubPathname());
            $this->assertEquals('Debug/DebugIterator.php', $it->getSubPathname());

            break;
        }
        $this->assertGreaterThan(0, $this->getNumAssertions());
    }
}
