<?php

if (php_sapi_name() !== 'cli') {
    die('Only CLI mode is supported');
}

// Bootstrap the Laravel application
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Create a console kernel instance and bootstrap it
$kernel = $app->make(Kernel::class);
//$kernel = App::make(Illuminate\Contracts\Console\Kernel::class);
//$app = App::getInstance();
$kernel->bootstrap();

function logJob($class, $method, $status) {
    $logMessage = date('Y-m-d H:i:s') . " | Class: $class | Method: $method | Status: $status\n";
    file_put_contents(storage_path('logs/background_jobs.log'), $logMessage, FILE_APPEND);
}

function logError($message) {
    file_put_contents(storage_path('logs/background_jobs_errors.log'), $message, FILE_APPEND);
}

if ($argc < 3) {
    die("Usage: php run-job.php ClassName methodName \"param1,param2\"\n");
}

// Retrieve delay from arguments (if provided)
$delay = isset($argv[4]) ? (int)$argv[4] : 0; // Fourth argument for delay

if ($delay > 0) {
    sleep($delay); // Delayed execution
}


// Retrieve class and method from arguments
$className = $argv[1] ?? null;
$methodName = $argv[2] ?? null;
$params = isset($argv[3]) ? explode(',', $argv[3]) : [];

// Load job configuration
//$config = config('background-jobs');

// Assuming that you load your config somewhere here
$config = require 'config/background-jobs.php';

Log::info('Attempting to run job', [
    'className' => $className,
    'methodName' => $methodName,
    'params' => $params,
    'config' => $config,
]);


// Security check for allowed jobs
if (!isset($config[$className]) || !in_array($methodName, $config[$className])) {
    die("The job $className::$methodName is not allowed.\n");
}

// if (isset($config[$className]) && in_array($methodName, $config[$className])) {
//     // Assume you instantiate your JobClass here
//     $jobClass = new $className();
//     $paramArray = explode(',', $params);

//     // Call the method dynamically
//     call_user_func_array([$jobClass, $methodName], $paramArray);
// } else {
//     Log::error("The job {$className}::{$methodName} is not allowed.");
//     echo "The job $className::$methodName is not allowed.\n";
// }

// Function to get a sorted job queue based on priority
// function getJobQueueSortedByPriority() {
//     // This function should return an array of job objects.
//     // For example: each job object should have `class`, `method`, and `priority` properties.

//     // You can implement your job fetching logic here.
//     $jobs = [
//         // Example job objects with dummy data
//         (object)['class' => 'JobA', 'method' => 'handle', 'priority' => 1],
//         (object)['class' => 'JobB', 'method' => 'handle', 'priority' => 3],
//         (object)['class' => 'JobC', 'method' => 'handle', 'priority' => 2]
//     ];

//     return $jobs;
// }

// $jobQueue = getJobQueueSortedByPriority();

// // Sort jobs by priority
// usort($jobQueue, function ($a, $b) {
//     return $b->priority <=> $a->priority; // Higher priority first
// });

$attempts = 0;
$maxAttempts = config('background-jobs.retry_attempts');

// foreach ($jobQueue as $job) {
//     $className = $job->class;
//     $methodName = $job->method;

    do {
        try {
            // Instantiate the job class and call the method
            $reflectionClass = new ReflectionClass($className);
            $params = array_map('trim', $params);
            $jobInstance = $reflectionClass->newInstance();
            $jobInstance->$methodName(...$params);
            logJob($className, $methodName, 'success');
            break; // Job succeeded
        } catch (\Exception $e) {
            // Handle exceptions
            $attempts++;
            logJob($className, $methodName, 'failed: ' . $e->getMessage());
            logError(date('Y-m-d H:i:s') . " | Error: " . $e->getMessage() . "\n");

            if ($attempts >= $maxAttempts) {
                break;
            }

            sleep(config('background-jobs.retry_delay'));
        }
    } while ($attempts < $maxAttempts);
//}

?>
