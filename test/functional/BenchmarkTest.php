<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2015 hakre <http://hakre.wordpress.com/>
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

class BenchmarkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function typeCheckingEfficiency()
    {
        $iterations = 10000;
        $result = null;

        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $result = $result + 1;
        }
        $offset = microtime(true) - $start;

        $info = null;

        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $result = !in_array(gettype($info), array('integer', 'string'), true);
        }
        $resultA = microtime(true) - $start;

        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $result = !is_int($info) && !is_string($info);
        }
        $resultB = microtime(true) - $start;

        $this->assertLessThanOrEqual($resultA - $offset, $resultB - $offset, 'is_int/is_string is faster than gettpye and in_array');
    }
}
