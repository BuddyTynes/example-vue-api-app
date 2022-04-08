<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicantSkill;

class Applicants extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'skills',
        'status',
    ];

    public function skills()
    {
        return $this->hasMany(ApplicantSkill::class, 'applicant_id')->with('skill');
    }

}
