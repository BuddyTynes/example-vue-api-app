<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skills;

class ApplicantSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'skill_id',
    ];

    public function skill()
    {
        return $this->belongsTo(Skills::class, 'skill_id');
    }
}
