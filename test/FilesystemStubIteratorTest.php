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
 * Class FilesystemStubIteratorTest
 *
 * @covers FilesystemStubIterator
 */
class FilesystemStubIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $subject = new FilesystemStubIterator('./world');
        $this->assertInstanceOf('FilesystemStubIterator', $subject);

        /**
         * @see FilesystemIterator
         * @see DirectoryIterator
         * @see SplFileInfo
         */
        $this->assertInstanceOf('FilesystemIterator', $subject);
        $this->assertInstanceOf('DirectoryIterator', $subject);
        $this->assertInstanceOf('SplFileInfo', $subject);
    }

    /**
     * @test
     */
    public function flags()
    {
        $iterator = new FilesystemStubIterator(__DIR__ . '/does-not-exists');
        $this->assertEquals(4096, $iterator->getFlags());
        $iterator->setFlags(null);
        $this->assertEquals(0, $iterator->getFlags());
    }

    /**
     * @test
     */
    public function getFileInfo()
    {
        $iterator = new FilesystemStubIterator(__DIR__ . '/does-not-exists');
        $info     = $iterator->getFileInfo();
        $this->assertInstanceOf('SplFileInfo', $info);
        $info = $iterator->getFileInfo('FilesystemStubIterator');
        $this->assertInstanceOf('SplFileInfo', $info);
        $this->assertInstanceOf('FilesystemStubIterator', $info);
    }

    /**
     * @test
     */
    public function getPathInfo()
    {
        $iterator = new FilesystemStubIterator(__DIR__ . '/does-not-exists');
        $info     = $iterator->getPathInfo();
        $this->assertInstanceOf('SplFileInfo', $info);
        $info = $iterator->getPathInfo('FilesystemStubIterator');
        $this->assertInstanceOf('SplFileInfo', $info);
        $this->assertInstanceOf('FilesystemStubIterator', $info);
    }

    /**
     * @test
     */
    public function openFileWithContext()
    {
        $stub   = new FilesystemStubIterator('data:text/plain;charset=us-ascii,hello+world');
        $result = $stub->openFile('r', false, stream_context_get_default());
        $this->assertInstanceOf('SplFileObject', $result);
        $this->assertEquals('hello world', $result->getCurrentLine());
    }

    /**
     * @test
     */
    public function validity()
    {
        $stub = new FilesystemStubIterator('/def/jam/nulsen');
        $this->assertFalse($stub->valid()); # always false
        $stub = new FilesystemStubIterator(__DIR__);
        $this->assertFalse($stub->valid()); # always false

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
                $this->assertObjectEquals($expectedVal, $actualVal, $name);
            } else {
                $this->assertSame($expectedVal, $actualVal, sprintf('%s() call', $name));
            }
        }
    }

    private function assertObjectEquals($expected, $actual, $message = '')
    {
        $message = 'assert obj from ' . $message;
        $this->assertInstanceOf(get_class($expected), $actual, $message);
        $this->assertSame(get_class($expected), get_class($actual), $message);

        // assert getters
        $refl = new ReflectionObject($expected);
        foreach ($refl->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $name = $method->getName();

            $exclude = array(
                '__construct',
                'getLinkTarget', // RuntimeException: Unable to read link
                '_bad_state_ex', // LogicException: The parent constructor was not called: the object is in an invalid state
                'fpassthru', // would output
                'getCurrentLine', // RuntimeException: Cannot read from file
            );
            if ($method->getParameters() || in_array($name, $exclude)) {
                continue;
            }

            $expectedVal = call_user_func(array($expected, $name));
            $actualVal   = call_user_func(array($actual, $name));
            $this->assertEquals($expectedVal, $actualVal, sprintf('%s %s() call', $message, $name));
        }
    }
}
