<?php

namespace App\Services;

use App\Services\Repositories\JobRepository;

class JobService
{
    protected $repo;


    public function __construct(JobRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listJobs()
    {
        return $this->repo->getAllPublished();
    }

    public function myJobs($userId)
    {
        return $this->repo->getByUser($userId);
    }

    public function createJob($userId, array $data)
    {
        $data['user_id'] = $userId;
        $data['status'] = $data['status'] ?? 'draft';
        return $this->repo->create($data);
    }

    public function updateJob($jobId, array $data)
    {
        return $this->repo->update($jobId, $data);
    }

    public function deleteJob($jobId)
    {
        return $this->repo->delete($jobId);
    }
}
