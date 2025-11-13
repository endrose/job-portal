<?php

namespace App\Services\Repositories;

use App\Models\Application;

class ApplicationRepository
{
    public function create(array $data)
    {
        return Application::create($data);
    }


    public function getByJob($jobId)
    {
        return Application::where('job_id', $jobId)->latest()->get();
    }

    public function delete($id)
    {
        $app = Application::findOrFail($id);
        return $app->delete();
    }
}


