<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'grade_section',
        'treatment_id',
        'diagnose',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
