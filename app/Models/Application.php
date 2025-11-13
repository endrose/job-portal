<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;


    protected $fillable = [
        'job_id',
        'user_id',
        'cv_id',
        'experience',
        'expected_salary',
    ];


    public function freelancer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id');
    }
}
