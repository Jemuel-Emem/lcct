<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'name',
        'grade_section',
        'date',
        'complain',
        'time_in',
        'time_out',
    ];

    public function prescriptions()
{
    return $this->hasMany(Prescription::class);
}
}
