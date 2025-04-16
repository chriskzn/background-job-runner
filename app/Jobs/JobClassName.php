<?php

namespace App\Jobs;

class JobClassName
{
    public $priority = 1; // Default priority
    // public $priority;

    // public function __construct($priority = 1) {
    //     $this->priority = $priority; // Set priority through constructor
    // }
    public function allowedMethod1($param1, $param2)
    {
        // Your logic here
        echo "Running allowedMethod1 with params: $param1, $param2\n";
    }

    public function allowedMethod2($param1)
    {
        // Your logic here
        echo "Running allowedMethod2 with param: $param1\n";
    }
}

// class JobA {
//     public function handle($param1, $param2) {
//         // Job handling logic
//         echo "JobA executed with params: $param1, $param2\n";
//     }
// }

// class JobB {
//     public function handle($param1, $param2) {
//         // Job handling logic
//         echo "JobB executed with params: $param1, $param2\n";
//     }
// }

// class JobC {
//     public function handle($param1, $param2) {
//         // Job handling logic
//         echo "JobC executed with params: $param1, $param2\n";
//     }
// }

?>
