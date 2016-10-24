<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\Config;
use Hal\Application\Config\Configuration;
use Symfony\Component\Yaml\Yaml;

/**
 * Load a config file
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class Loader
{
    /**
     * Validator of configuration
     *
     * @var Hydrator
     */
    private $hydrator;

    /**
     * Constructor
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator) {
        $this->hydrator = $hydrator;
    }

    /**
     * Load config file
     *
     * @param $filename
     * @return Configuration
     * @throws \RuntimeException
     */
    public function load($filename) {

        if(!\file_exists($filename) ||!\is_readable($filename)) {
            throw new \RuntimeException('configuration file is not accessible');
        }
        $content = file_get_contents($filename);
        $parser = new Yaml();
        $array = $parser->parse($content);
        if (null === $array) {
            throw new \RuntimeException('configuration file is empty');
        }

        return $this->hydrator->hydrates(new Configuration, $array);

    }
}