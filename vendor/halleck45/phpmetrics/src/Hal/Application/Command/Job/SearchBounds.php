<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Application\Command\Job;
use Hal\Component\Bounds\BoundsInterface;
use Hal\Component\Result\ResultCollection;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Search bounds
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class SearchBounds implements JobInterface
{

    /**
     * Bound
     *
     * @var \Hal\Component\Bounds\BoundsInterface
     */
    private $bound;

    /**
     * Output
     *
     * @var OutputInterface
     */
    private $output;

    /**
     * Constructor
     * @param OutputInterface $output
     * @param BoundsInterface $bound
     */
    public function __construct(OutputInterface $output, BoundsInterface $bound)
    {
        $this->bound = $bound;
        $this->output = $output;
    }

    /**
     * @inheritdoc
     */
    public function execute(ResultCollection $collection, ResultCollection $groupedResults)
    {
        $this->bound->calculate($collection);
    }

}