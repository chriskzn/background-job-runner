<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class JobDashboardController extends Controller
{
    //
    public function index()
    {
        // Fetch all jobs from log, status or cache accordingly
        $jobLogs = Cache::get('job_logs', []);
        return view('dashboard.index', compact('jobLogs'));
    }

    public function cancelJob($jobId)
    {
        // Logic to cancel the running job
    }
}
