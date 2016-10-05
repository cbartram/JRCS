<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests\Iterator;

use Symfony\Component\Finder\Iterator\FilenameFilterIterator;

class FilenameFilterIteratorTest extends IteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($matchPatterns, $noMatchPatterns, $expected)
    {
        $inner = new InnerNameIterator(array('tests.php', 'tests.py', 'foo.php'));

        $iterator = new FilenameFilterIterator($inner, $matchPatterns, $noMatchPatterns);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        return array(
            array(array('tests.*'), array(), array('tests.php', 'tests.py')),
            array(array(), array('tests.*'), array('foo.php')),
            array(array('*.php'), array('tests.*'), array('foo.php')),
            array(array('*.php', '*.py'), array('foo.*'), array('tests.php', 'tests.py')),
            array(array('/\.php$/'), array(), array('tests.php', 'foo.php')),
            array(array(), array('/\.php$/'), array('tests.py')),
        );
    }
}

class InnerNameIterator extends \ArrayIterator
{
    public function current()
    {
        return new \SplFileInfo(parent::current());
    }

    public function getFilename()
    {
        return parent::current();
    }
}
