<?php

namespace App\Jobs;

class JobClassName
{
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

?>
