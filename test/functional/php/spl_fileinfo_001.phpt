--TEST--
SplFileInfo
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$fi = new SplFileInfo(__FILE__);

echo "-- GetFileInfo() behavior --\n";
$get = $fi->getFileInfo();
var_dump($get === $fi);
var_dump(get_class($get));
try {
    $get = $fi->getFileInfo(null);
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}
$get = $fi->getFileInfo("SplFileInfo");
var_dump(get_class($get));
$get = $fi->getFileInfo('FilesystemStubIterator');
var_dump(get_class($get));
$get = $fi->getPathInfo('DirectoryIterator');
var_dump(get_class($get));
?>
--EXPECT--
-- GetFileInfo() behavior --
bool(false)
string(11) "SplFileInfo"
string(24) "UnexpectedValueException"
string(100) "SplFileInfo::getFileInfo() expects parameter 1 to be a class name derived from SplFileInfo, '' given"
string(11) "SplFileInfo"
string(22) "FilesystemStubIterator"
string(17) "DirectoryIterator"
