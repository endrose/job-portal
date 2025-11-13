<?php

namespace App\Services\Repositories;

use App\Models\Job;

class JobRepository

{
    public function getAllPublished()
    {
        return Job::with('employer')->where('status', 'published')->latest()->get();
    }

    public function getByUser($userId)
    {
        return Job::where('user_id', $userId)->latest()->get();
    }

    public function create(array $data)
    {
        return Job::create($data);
    }

    public function find($id)
    {
        return Job::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $job = Job::findOrFail($id);
        $job->update($data);
        return $job;
    }

    public function delete($id)
    {
        $job = Job::findOrFail($id);
        return $job->delete();
    }
}
