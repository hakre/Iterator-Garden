--TEST--
Iterator-Garden: MultipleIterator (same array key on different info due to internal string to integer conversion)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
$a   = new ArrayIterator(array('A'));
$b   = new ArrayIterator(array('B'));

echo "-- Two empty iterators attached with infos that are different but same array key --\n";
$mitEmpty = clone $mit;
$mitEmpty->setFlags($mit->getFlags());
$mitEmpty->attachIterator($e1 = new EmptyIterator(), "2");
$mitEmpty->attachIterator($e2 = new EmptyIterator(), 2);
var_dump($mitEmpty->countIterators());
$mitEmpty->rewind();
var_dump($mitEmpty->current());
unset($mitEmpty);

echo "-- Two iterators attached with infos that are different but same array key --\n";
$mit->attachIterator($a, 2);
$mit->attachIterator($b, "2");
var_dump($mit->countIterators());
$mit->rewind();
var_dump($mit->current());
$mit->setFlags($mit::MIT_KEYS_NUMERIC);
var_dump($mit->current());
?>
--EXPECT--
-- Two empty iterators attached with infos that are different but same array key --
int(2)
array(1) {
  [2]=>
  NULL
}
-- Two iterators attached with infos that are different but same array key --
int(2)
array(1) {
  [2]=>
  string(1) "B"
}
array(2) {
  [0]=>
  string(1) "A"
  [1]=>
  string(1) "B"
}
