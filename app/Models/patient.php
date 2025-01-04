<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'treatment_id',
        'name',
        'grade_section',
        'date',
        'diagnose',
        'time_in',
        'time_out',
    ];

    public function prescriptions()
{
    return $this->hasMany(Prescription::class);
}
public function treatment()
{
    return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
}

public function user()
{
    return $this->belongsTo(User::class, 'student_number', 'student_number');
}


}
