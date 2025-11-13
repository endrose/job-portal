<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Services\JobService;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    //
    protected $service;


    public function __construct(JobService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return JobResource::collection($this->service->listJobs());
    }


    public function viewJob()
    {
        $response = Http::get('http://localhost:8001/api/jobs');
        $jobs = $response->json();

        // ambil hanya bagian 'data' kalau ada
        $jobs = $jobs['data'] ?? $jobs;

        return view('jobs.index', compact('jobs'));
    }

    // public function viewJob(){
    //     $jobs = $this->service->listJobs();

    //     return view('jobs.index', [
    //         'jobs' => $jobs,
    //     ]);


    // }
}
