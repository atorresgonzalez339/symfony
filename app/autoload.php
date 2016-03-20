<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('PhpThumb_', __DIR__.'/../libraries/phpthumb/lib');
$loader->add('JMS', __DIR__.'/../vendor/bundles');
$loader->add('JMS', __DIR__.'/../vendor/cg-library/src');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
