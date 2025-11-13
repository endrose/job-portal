<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Seeder;

class CvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $freelancers = User::where('role','freelancer')->get();

        foreach ($freelancers as $freelancer) {
            Cv::create([
                'user_id'=> $freelancer->id,
                'file_path'=> 'uploads/cv_'.$freelancer->id.'.pdf',
            ]);
        }

    }
}
