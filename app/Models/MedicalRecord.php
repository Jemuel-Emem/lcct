<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_number',
        'name',
        'sex',
        'date_of_birth',
        'address',
        'grade',
        'age',
        'height',
        'weight',
        'vision',
        'bp',
        'nameoffather',
        'fatheroccupation',
        'nameofmother',
        'motheroccupation',
        'document_path',
        'year_uploaded',
    ];

}
