<?php
require_once "vendor/autoload.php";

define("APP_PATH", __DIR__);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;

require "config/db-config.php";

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => DB_USER,
    'password' => DB_PASSWD,
    'dbname'   => DB_NAME,
);

/**
 * @var \Symfony\Component\DependencyInjection\ContainerBuilder $container
 */
$container = require_once "config/container.php";