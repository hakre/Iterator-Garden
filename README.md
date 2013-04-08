Iterator-Garden
===============

Examples of Iterators. Let Iterators grow like flowers in the garden.

## Example Iterator Classes

Short table of exemplary iterator classes not part of PHP SPL:

| Class | Description | Author |
| ------------- | ------------- | --------- |
| [DecoratingIterator] | Decorate with Callable or classname | Marcus Börger |
| [DecoratingKeyValueIterator] | Decorate key and value | Marcus Börger |
| [DualIterator] | Synchronous iteration over two iterators | Marcus Börger |
| [FetchIterator] | Fetch iteration values until false | hakre |
| [FilterChainIterator] | FilterIterator for many callbacks | salathe |
| [KeyIterator] | Iterate over keys | Marcus Börger |
| [KeyValueIterator] | Iterate over Keys and Values in parallel | Marcus Börger |
| [PadIterator] | Pad an iteration up to a number of values | hakre |
| [RandomIterator] | Reservoir Sampling iteration | hakre |
| [RecursiveDOMIterator] | Iterate over the entire DOM tree | Gordon Oheim |
| [SortableIterator] | Sortable Iterator (Files) | Fabien Potencier |
| [SortingIterator] | Sorting Iterators | salathe |
| [TableIterator] | Turn any Iterator into rows and columns | hakre |

[DecoratingIterator]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
[DecoratingKeyValueIterator]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
[DualIterator]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/DualIterator.php?r=6
[FetchIterator]: http://hakre.wordpress.com/2012/02/28/some-php-iterator-fun/
[FilterChainIterator]: https://github.com/salathe/spl-examples/wiki/FilterChain-Iterator
[KeyIterator]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
[KeyValueIterator]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
[PadIterator]: http://hakre.wordpress.com/2012/02/28/some-php-iterator-fun/
[RandomIterator]: http://hakre.wordpress.com/2013/01/08/getting-n-random-elements-out-of-an-iterator-randomiterator/
[RecursiveDOMIterator]: https://github.com/salathe/spl-examples/wiki/RecursiveDOMIterator
[SortableIterator]: https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Finder/Iterator/SortableIterator.php
[SortingIterator]: https://github.com/salathe/spl-examples/wiki/Sorting-Iterators
[TableIterator]: http://hakre.wordpress.com/2012/02/28/some-php-iterator-fun/

[M. Boerger Iterator Madness]: https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6

## Resources

- [salathe spl-examples](https://github.com/salathe/spl-examples/wiki)
- [cballou / PHP-SPL-Iterator-Interface-Examples](https://github.com/cballou/PHP-SPL-Iterator-Interface-Examples)
- [SPL - Standard PHP Library Doxygen API Docs (Marcus Börger)](http://www.php.net/~helly/php/ext/spl/)
- [Introduction to Standard PHP Library (SPL) (Kevin Waterson)](http://www.phpro.org/tutorials/Introduction-to-SPL.html)
- [SPL AppendIterator (Kevin Waterson)](http://www.phpro.org/tutorials/SPL-AppendIterator.html)
- [Using SPL Iterators, Part 2 (Stefan Froelich)](http://phpmaster.com/using-spl-iterators-2/)
- [The Standard PHP Library (SPL) (Ben Ramsey)](http://devzone.zend.com/1075/the-standard-php-library-spl/)
- [Standard PHP Library iterators (Slawek Lukasiewicz)](http://www.leftjoin.net/2011/04/standard-php-library-iterators/)
- [Iterating over life with SPL Iterators I: Directories (Rafael Dohms)](http://blog.doh.ms/2009/10/08/iterating-over-life-with-spl-iterator)
- [Getting N Random Elements out of an Iterator – RandomIterator (hakre)](http://hakre.wordpress.com/2013/01/08/getting-n-random-elements-out-of-an-iterator-randomiterator/)
- [Iterating over Multiple Iterators at Once (hakre)](http://hakre.wordpress.com/2012/04/05/iterating-over-multiple-iterators-at-once/)
- [How does RecursiveIteratorIterator work in PHP? (hakre)](http://stackoverflow.com/a/12236744/367456)
- [Some PHP Iterator Fun (hakre)](http://hakre.wordpress.com/2012/02/28/some-php-iterator-fun/)
- [How foreach actually works (NikiC)](http://stackoverflow.com/a/14854568/367456)
- [IteratorIterator - PHP Inconsistencies And WTFs (ircmaxell)](http://blog.ircmaxell.com/2011/10/iteratoriterator-php-inconsistencies.html)

## Slides

- [Functional Programming with SPL Iterators (by Marcus Börger; 2004; PDF)](http://somabo.de/talks/200411_php_conference_frankfrurt_introduction_functional_programming_with_iterators.pdf)
- [SPL Iterators (by Elliott White III; 2008; PDF)](http://eliw.com/presentations/2008/dcphp-2008-iterators.pdf)
