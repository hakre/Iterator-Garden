--TEST--
Check gettype behavior
--FILE--
<?php
var_dump(gettype(null));
var_dump(gettype('string'));
var_dump(gettype(new stdClass()));
var_dump(gettype(array()));
var_dump(gettype(new EmptyIterator()));
?>
--EXPECT--
string(4) "NULL"
string(6) "string"
string(6) "object"
string(5) "array"
string(6) "object"
