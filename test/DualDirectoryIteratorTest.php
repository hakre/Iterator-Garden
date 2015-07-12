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
 * @covers DualDirectoryIterator
 */
class DualDirectoryIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $dual = new DualDirectoryIterator('.', '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     */
    public function creationWithFilesystemIterator()
    {
        $iter = new FilesystemIterator('.');
        $dual = new DualDirectoryIterator($iter, '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     */
    public function creationWithSplFileInfo()
    {
        $splFileInfo = new SplFileInfo('.');
        $dual        = new DualDirectoryIterator($splFileInfo, '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage FilesystemIterator or string expected
     */
    public function creationWithArray()
    {
        new DualDirectoryIterator(null, null);
    }

    /**
     * @test
     */
    public function creationWithFilePaths()
    {
        $dual = new DualDirectoryIterator(__FILE__, __FILE__);
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     */
    public function creationWithNonexistantPaths()
    {
        $splFileInfo = new SplFileInfo('.');
        $dual        = new DualDirectoryIterator($splFileInfo, '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     * @expectedException LogicException
     */
    public function unrewound()
    {
        $dual = new DualDirectoryIterator('.', '.');
        $dual->current(); // current() w/o rewind()
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Not implemented.
     */
    public function seek()
    {
        $dual = new DualDirectoryIterator('.', '.');
        $dual->seek(1);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function invalidFileInfoClass()
    {
        $dual = new DualDirectoryIterator('.', '.');

        $dual->setInfoClass('IteratorIterator');
    }

    /**
     * @test
     */
    public function nullFileInfoClass()
    {
        $dual = new DualDirectoryIterator('.', '.');
        $dual->setInfoClass(null);
        $this->assertInstanceOf('SplFileInfo', $dual->getFileInfo());
    }

    /**
     * @test
     */
    public function fileInfoClass()
    {
        $dual = new DualDirectoryIterator('.', '.');

        $infoClass = 'FilesystemStubIterator';
        $dual->setInfoClass($infoClass);

        $dual->rewind();
        $first = $dual->current();
        $this->assertInstanceOf($infoClass, $first);

        list($a, $b) = $dual->getFileInfos();
        $this->assertInstanceOf($infoClass, $a);
        $this->assertInstanceOf($infoClass, $b);
        $this->assertEquals($a, $b);
    }

    /**
     * @test
     */
    public function flags()
    {
        $dual = new DualDirectoryIterator('.', '.');
        $this->assertEquals(4096, $dual->getFlags());
        $dual->setFlags();
        $this->assertEquals(0, $dual->getFlags());
        $dual->setFlags(4096);
        $this->assertEquals(4096, $dual->getFlags());
    }

    /**
     * @test
     */
    public function directoryIteration()
    {
        $dual = new DualDirectoryIterator(__DIR__, __DIR__ . '/../src');
        foreach ($dual as $done) {
            $this->assertInternalType('string', $dual->key());
            $this->assertInstanceOf('SplFileInfo', $dual->getFileInfo());
            $this->assertInstanceOf('SplFileInfo', $dual->getPathInfo());

            $dirs = $dual->getInnerDirectories();
            $this->assertInstanceOfOrNull('SplFileInfo', $dirs[0]);
            $this->assertInstanceOfOrNull('SplFileInfo', $dirs[1]);

            $dual->setFlags($dual->getFlags() | $dual::CURRENT_AS_SELF);
            $dirs = $dual->getInnerDirectories();
            $this->assertInstanceOf('FileSystemIterator', $dirs[0]);
            $this->assertInstanceOf('FileSystemIterator', $dirs[1]);

            $dual->setFlags($dual->getFlags() ^ $dual::CURRENT_AS_SELF | $dual::CURRENT_AS_PATHNAME);
            $dirs = $dual->getInnerDirectories();
            $this->assertInternalType('string', $dirs[0]);
            $this->assertInternalType('string', $dirs[1]);

            $dual->setFlags($dual->getFlags() ^ $dual::CURRENT_AS_PATHNAME);
        }
    }

    private function assertInstanceOfOrNull($expected, $actual)
    {
        if (null === $actual) {
            $this->assertNull($actual);

            return;
        }

        $this->assertInstanceOf($expected, $actual);
    }
}
