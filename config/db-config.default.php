<?php
define("DB_USER", "my user");
define("DB_PASSWD", "my password");

if (php_sapi_name() != "cli") {
    if ($_SERVER["SERVER_PORT"] == 8888) {
        define("DB_NAME", "workout_test");
    } else {
        define("DB_NAME", "workout");
    }
} else {
    if (defined("TEST_RUN")) {
        define("DB_NAME", "workout_test");
    } else {
        define("DB_NAME", "workout");
    }
}