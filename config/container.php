<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

$container = new ContainerBuilder();
require_once __DIR__ . "/dic/services.php";

return $container;