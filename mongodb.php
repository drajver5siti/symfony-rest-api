<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Symfony\Component\Console\Application;

if (!file_exists($file = __DIR__ . '/vendor/autoload.php')) {
    throw new RuntimeException('Install dependencies to run this script.');
}

$loader = require_once $file;
$loader->add('Documents', __DIR__);

AnnotationRegistry::registerLoader([$loader, 'loadClass']);


$config = new Configuration();
$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/Hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('doctrine_odm');

$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/Documents'));

$dm = DocumentManager::create(null, $config);


$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    [
        'dm' => new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($dm),
    ]
);

$app = new Application('Doctrine MongoDB ODM');
$app->setHelperSet($helperSet);
$app->addCommands(
    [
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\ClearCache\MetadataCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\UpdateCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\ShardCommand(),
    ]
);

$app->run();
