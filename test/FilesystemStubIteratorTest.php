<?php
/**
 * Iterator Garden
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
