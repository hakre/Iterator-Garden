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

class FilesystemStubIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $subject = new FilesystemStubIterator('./world');
    }

    public function testSplFileInfoBehavior()
    {
        $path     = __FILE__;
        $expected = new SplFileInfo($path);

        $actual = new FilesystemStubIterator($path);

        $refl = new ReflectionObject($expected);
        foreach ($refl->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $name = $method->getName();

            if ($method->getParameters() && $name === '__construct') {
                continue;
            }

            try {
                $expectedVal = call_user_func(array($expected, $name));
            } catch (Exception $expectedException) {
                try {
                    $actualVal = call_user_func(array($actual, $name));
                    $this->fail('Expected Exception not thrown');
                } catch (Exception $actualException) {
                    $this->assertEquals($expectedException, $actualException);
                    continue;
                }
            }
            $actualVal = call_user_func(array($actual, $name));
            if (is_object($expectedVal)) {
                $this->assertEquals($expectedVal, $actualVal, sprintf('%s() call', $name));
            } else {
                $this->assertSame($expectedVal, $actualVal, sprintf('%s() call', $name));
            }
        }
    }
}
