--TEST--
FilesystemIterator
--FILE--
<?php
$fi = new FilesystemIterator(__DIR__);

echo "-- Flags --\n";
var_dump($fi->getFlags());
@$fi->setFlags();
var_dump($php_errormsg);
var_dump($fi->getFlags());
@$fi->setFlags(null);
var_dump($fi->getFlags());
$fi->setFlags(4096);

echo "-- Flags: CURRENT_AS_FILEINFO --\n";
var_dump(get_class($fi->current()));

echo "-- Flags: CURRENT_AS_SELF --\n";
$fi->setFlags($fi->getFlags() | $fi::CURRENT_AS_SELF);
var_dump(get_class($fi->current()));
var_dump($fi === $fi->current());

echo "-- Flags: CURRENT_AS_PATHNAME --\n"; # CURRENT_AS_SELF must be explicitly unset
$fi->setFlags($fi->getFlags() ^ $fi::CURRENT_AS_SELF  | $fi::CURRENT_AS_PATHNAME );
var_dump($fi->getFlags() & $fi::CURRENT_AS_PATHNAME);
var_dump(is_string($fi->current()));
$pos = strrpos($fi->current(), "$fi");
var_dump($pos + strlen($fi) === strlen($fi->current()));
?>
--EXPECT--
-- Flags --
int(4096)
string(67) "FilesystemIterator::setFlags() expects exactly 1 parameter, 0 given"
int(4096)
int(0)
-- Flags: CURRENT_AS_FILEINFO --
string(11) "SplFileInfo"
-- Flags: CURRENT_AS_SELF --
string(18) "FilesystemIterator"
bool(true)
-- Flags: CURRENT_AS_PATHNAME --
int(32)
bool(true)
bool(true)
