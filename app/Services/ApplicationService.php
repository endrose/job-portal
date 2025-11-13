<?php

namespace App\Services;

use App\Models\Cv;
use App\Services\Repositories\ApplicationRepository;

class ApplicationService
{
    public function __construct(ApplicationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function applyJob($userId, array $data, $cvFile)
    {
        // 1. Simpan file CV
        $cvPath = $cvFile->store('cvs', 'public');

        // 2. Simpan file CV ke tabel cvs
        $cv = Cv::create([
            'user_id' => $userId,
            'file_path' => $cvPath,
        ]);

        // 3. Tambah data untuk table applications
        $data['user_id'] = $userId;
        $data['cv_id'] = $cv->id; // WAJIB ADA

        // 4. Simpan lewat repository
        return $this->repo->create($data);
    }
}
