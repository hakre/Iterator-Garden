# List of Traversables in PHP

List of PHP classes that are [Traversable](http://php.net/class.Traversable), grouped by their extension ordered A-Z
with the exception that Core and SPL are at the very end of the list.

Behind every classname there is also a list of the implemented core classes/interface that are related to iteration (if
those are additional to Traversable).

## [Date/Time](http://php.net/book.datetime) (date)

- [DatePeriod](http://php.net/class.DatePeriod)

## [DOM](http://php.net/book.dom) (dom)

- [DOMNamedNodeMap](http://php.net/class.DOMNamedNodeMap)
- [DOMNodeList](http://php.net/class.DOMNodeList)

## [Mysqli](http://php.net/book.mysqli) (mysqli)

- [mysqli_result](http://php.net/class.mysqli_result)

## [PDO](http://php.net/book.pdo) (PDO)

- [PDOStatement](http://php.net/class.PDOStatement)

## [Phar](http://php.net/book.phar) (Phar)

- [Phar](http://php.net/class.Phar) (Iterator)
- [PharData](http://php.net/class.PharData) (Iterator)

## [SimpleXML](http://php.net/book.simplexml) (SimpleXML)

- [SimpleXMLElement](http://php.net/class.SimpleXMLElement)
- [SimpleXMLIterator](http://php.net/class.SimpleXMLIterator) (Iterator)

## [Predefined Interfaces and Classes](http://php.net/reserved.interfaces) (Core)

- [Generator](http://php.net/class.Generator) (Iterator)

## [Iterators](http://php.net/spl.iterators) (SPL)

- [AppendIterator](http://php.net/class.AppendIterator) (Iterator, IteratorIterator)
- [ArrayIterator](http://php.net/class.ArrayIterator) (Iterator)
- [ArrayObject](http://php.net/class.ArrayObject) (IteratorAggregate)
- [CachingIterator](http://php.net/class.CachingIterator) (Iterator, IteratorIterator)
- [CallbackFilterIterator](http://php.net/class.CallbackFilterIterator) (Iterator, IteratorIterator)
- [DirectoryIterator](http://php.net/class.DirectoryIterator) (Iterator)
- [EmptyIterator](http://php.net/class.EmptyIterator) (Iterator)
- [FilesystemIterator](http://php.net/class.FilesystemIterator) (Iterator)
- [FilterIterator](http://php.net/class.FilterIterator) (Iterator, IteratorIterator)
- [GlobIterator](http://php.net/class.GlobIterator) (Iterator)
- [InfiniteIterator](http://php.net/class.InfiniteIterator) (Iterator, IteratorIterator)
- [IteratorIterator](http://php.net/class.IteratorIterator) (Iterator)
- [LimitIterator](http://php.net/class.LimitIterator) (Iterator, IteratorIterator)
- [MultipleIterator](http://php.net/class.MultipleIterator) (Iterator)
- [NoRewindIterator](http://php.net/class.NoRewindIterator) (Iterator, IteratorIterator)
- [ParentIterator](http://php.net/class.ParentIterator) (Iterator, IteratorIterator)
- [RecursiveArrayIterator](http://php.net/class.RecursiveArrayIterator) (Iterator)
- [RecursiveCachingIterator](http://php.net/class.RecursiveCachingIterator) (Iterator, IteratorIterator)
- [RecursiveCallbackFilterIterator](http://php.net/class.RecursiveCallbackFilterIterator) (Iterator, IteratorIterator)
- [RecursiveDirectoryIterator](http://php.net/class.RecursiveDirectoryIterator) (Iterator)
- [RecursiveFilterIterator](http://php.net/class.RecursiveFilterIterator) (Iterator, IteratorIterator)
- [RecursiveIteratorIterator](http://php.net/class.RecursiveIteratorIterator) (Iterator)
- [RecursiveRegexIterator](http://php.net/class.RecursiveRegexIterator) (Iterator, IteratorIterator)
- [RecursiveTreeIterator](http://php.net/class.RecursiveTreeIterator) (Iterator)
- [RegexIterator](http://php.net/class.RegexIterator) (Iterator, IteratorIterator)
- [SplDoublyLinkedList](http://php.net/class.SplDoublyLinkedList) (Iterator)
- [SplFileObject](http://php.net/class.SplFileObject) (Iterator)
- [SplFixedArray](http://php.net/class.SplFixedArray) (Iterator)
- [SplHeap](http://php.net/class.SplHeap) (Iterator)
- [SplMaxHeap](http://php.net/class.SplMaxHeap) (Iterator)
- [SplMinHeap](http://php.net/class.SplMinHeap) (Iterator)
- [SplObjectStorage](http://php.net/class.SplObjectStorage) (Iterator)
- [SplPriorityQueue](http://php.net/class.SplPriorityQueue) (Iterator)
- [SplQueue](http://php.net/class.SplQueue) (Iterator)
- [SplStack](http://php.net/class.SplStack) (Iterator)
- [SplTempFileObject](http://php.net/class.SplTempFileObject) (Iterator)


----

This document covers PHP version 5.5.15 with the following extensions enabled (those
having at least one class - even if undocumented - are linked):

bcmath, calendar, Core ([Predefined Interfaces and Classes](http://php.net/reserved.interfaces)), ctype, curl
([cURL](http://php.net/book.curl)), date ([Date/Time](http://php.net/book.datetime)), dom
([DOM](http://php.net/book.dom)), ereg, filter, ftp, hash, iconv, imap, json, libxml
([libxml](http://php.net/book.libxml)), mbstring, mcrypt, mhash, mysqli ([Mysqli](http://php.net/book.mysqli)), mysqlnd,
odbc, openssl, pcre, PDO ([PDO](http://php.net/book.pdo)), pdo_mysql, Phar ([Phar](http://php.net/book.phar)),
Reflection ([Reflection](http://php.net/book.reflection)), session ([Sessions](http://php.net/book.session)), SimpleXML
([SimpleXML](http://php.net/book.simplexml)), soap ([SOAP](http://php.net/book.soap)), SPL
([Iterators](http://php.net/spl.iterators)), standard ([Predefined Classes](http://php.net/reserved.classes)), tidy
([Tidy](http://php.net/book.tidy)), tokenizer, wddx, Xdebug, xdebug, xml, xmlreader
([XMLReader](http://php.net/book.xmlreader)), xmlwriter ([XMLWriter](http://php.net/book.xmlwriter)), xsl
([XSL](http://php.net/book.xsl)), zip ([Zip](http://php.net/book.zip)), zlib
