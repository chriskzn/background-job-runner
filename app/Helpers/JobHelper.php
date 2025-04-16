<?php

function runBackgroundJob($class, $method, $params = []) {
    $sanitizedParams = implode(',', array_map('escapeshellarg', $params));
    $command = "php " . escapeshellarg(public_path('run-job.php')) . " " . escapeshellarg($class) . " " . escapeshellarg($method) . " \"$sanitizedParams\"";
    exec($command . " > /dev/null &"); // Run in background
}

?>
