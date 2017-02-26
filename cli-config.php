<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

$entityManager = $container->get(EntityManager::class);
return ConsoleRunner::createHelperSet($entityManager);