<?php declare(strict_types=1);

// Measure application speed.
define('APP_START', microtime(true));

// Connect the autoload of files + libraries.
require_once __DIR__ . '/vendor/autoload.php';

// Load .env file.
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Set defines with .env.
require_once __DIR__ . '/configs/defines.php';

// Output of errors in the debug mode.
if (APP_DEBUG) {
    if (ini_set('display_errors', '1') === false) {
        die('Unable to set display_errors');
    }
    if (ini_set('display_startup_errors', '1') === false) {
        die('Unable to set display_startup_errors');
    }
    error_reporting(E_ALL);
}

// Set the time zone.
/** @see http://php.net/manual/en/timezones.php */
if (! date_default_timezone_set(APP_TIMEZONE)) {
    die('Unable to set date_default_timezone_set');
}

try {
    // Connect to the database.
    $db = require __DIR__ . '/configs/db.php';
    new \Pixie\Connection($db['driver'], $db, 'QB');

    // Get a token from the received data from the user.
    \core\Token::parseInput();

} catch (Exception $e) {
    die($e->getMessage());
}
