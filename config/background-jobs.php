<?php

return [
    //'JobClass' => ['allowedMethod1', 'allowedMethod2'],
    'App\Jobs\JobClassName' => [
        'allowedMethod1',
        'allowedMethod2', // Add other allowed methods as needed
    ],
    //'AnotherJobClass' => ['anotherAllowedMethod'],
    'retry_attempts' => 3,
    'retry_delay' => 5,  // Seconds
];

?>
