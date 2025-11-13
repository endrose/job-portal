<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Cv;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freelancers = User::where('role', 'freelancer')->get();
        $publishedJobs = Job::where('status', 'published')->get();

        foreach ($freelancers as $freelancer) {
            $cv = Cv::where('user_id', $freelancer->id)->first();

            if (!$cv || $publishedJobs->isEmpty()) continue;

            $jobsToApply = $publishedJobs->random(min(3, $publishedJobs->count()));

            foreach ($jobsToApply as $job) {
                $alreadyApplied = Application::where('user_id', $freelancer->id)
                    ->where('job_id', $job->id)
                    ->exists();

                if (!$alreadyApplied) {
                    Application::create([
                        'job_id' => $job->id,
                        'user_id' => $freelancer->id,
                        'cv_id' => $cv->id,
                        'experience' => "Pengalaman kerja di bidang {$job->title} selama " . rand(1, 5) . " tahun",
                        'expected_salary' => rand(5000000, 10000000),
                    ]);
                }
            }
        }
    }
}
