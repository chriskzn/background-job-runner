<?php

// Include the Composer autoload file
require __DIR__ . '/../vendor/autoload.php'; // Adjust path to go one level up

// Include the Laravel application bootstrap file
$app = require_once __DIR__ . '/../bootstrap/app.php'; // Adjust path to go one level up

// Output success message
echo "Bootstrap file loaded successfully.";


?>
