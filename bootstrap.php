<?php
require "vendor/autoload.php";

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;

$user = "root";
$password = "root";

if ($_ENV["CODESHIP"] === "TRUE") {
    $user = $_ENV["MYSQL_USER"];
    $password = $_ENV["MYSQL_PASSWORD"];
}

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => $user,
    'password' => $password,
    'dbname'   => 'workout',
);

$paths = array(__DIR__ . "/config/doctrine");
$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);