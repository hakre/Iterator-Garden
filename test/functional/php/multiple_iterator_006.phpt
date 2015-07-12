--TEST--
Iterator-Garden: MultipleIterator (inner iterators alignment and exceptions)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator();
$empty = new EmptyIterator();
$array = new IteratorIterator(new ArrayIterator(range(1, 3)));

echo "-- Default flags, no iterators --\n";
var_dump($mit->getFlags());
var_dump($mit->countIterators());

echo "-- Partial info attached with assoc keys --\n";
$mit->setFlags($mit::MIT_KEYS_ASSOC | $mit::MIT_NEED_ANY);
$mit->attachIterator($empty, 'tag-first');
$mit->rewind();
var_dump($mit->valid());
$mit->attachIterator($array);
var_dump($mit->valid());
$array->rewind();
var_dump($mit->valid());
try {
    $mit->current();
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}
try {
    $mit->key();
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}

echo "-- Correct info, need all and invalidate previous valid subiterator --\n";
$mit->attachIterator($array, 'tag-second');
var_dump($mit->valid());
var_dump($array->valid());
for (; $array->valid(); $array->next());
var_dump($mit->valid());
var_dump($array->valid());
$mit->setFlags($mit::MIT_KEYS_ASSOC | $mit::MIT_NEED_ALL);
try {
    $mit->current();
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}
try {
    $mit->key();
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}
var_dump($mit->valid());
var_dump($array->valid());

?>
--EXPECT--
-- Default flags, no iterators --
int(1)
int(0)
-- Partial info attached with assoc keys --
bool(false)
bool(false)
bool(true)
string(24) "InvalidArgumentException"
string(36) "Sub-Iterator is associated with NULL"
string(24) "InvalidArgumentException"
string(36) "Sub-Iterator is associated with NULL"
-- Correct info, need all and invalidate previous valid subiterator --
bool(true)
bool(true)
bool(false)
bool(false)
string(16) "RuntimeException"
string(44) "Called current() with non valid sub iterator"
string(16) "RuntimeException"
string(40) "Called key() with non valid sub iterator"
bool(false)
bool(false)
