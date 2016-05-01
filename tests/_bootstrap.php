<?php
$projectBase = dirname(__DIR__);
$output = $projectBase . "/tests/_data/dump.sql";
echo shell_exec($projectBase . "/vendor/bin/doctrine orm:schema-tool:create --dump-sql > $output");

define("TEST_RUN", true);

require $projectBase . "/bootstrap.php";

\Codeception\Util\Fixtures::add("entityManager", $entityManager);