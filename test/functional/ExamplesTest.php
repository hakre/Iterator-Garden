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

class ExamplesTest extends PHPUnit_Framework_TestCase
{
    const EXAMPLES_GLOB = '/../../examples/*.php';

    /**
     * @see examples
     */
    public function provideExamples()
    {
        $result = glob(__DIR__ . self::EXAMPLES_GLOB);
        if (!$result) {
            return array();
        }

        $data = array();
        foreach($result as $file) {
            $expectationFile = sprintf("%s/examples/%s.out", __DIR__, basename($file));
            $data[] = array($file, $expectationFile);
        }

        return $data;
    }

    /**
     * @test
     * @dataProvider provideExamples
     */
    public function examples($file, $expectationFile)
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $actualFile = $expectationFile . '.last';
        file_put_contents($actualFile, $actual);
        $expected = file_get_contents($expectationFile);
        $this->assertSame($expected, $actual);
    }
}
