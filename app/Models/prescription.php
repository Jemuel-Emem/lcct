<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'treatment_id',
        'medicine_id',
        'quantity',
    ];


    // public function patient()
    // {
    //     return $this->belongsTo(Patient::class);
    // }

    // public function treatment()
    // {
    //     return $this->belongsTo(Treatment::class);
    // }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

// Prescription.php
public function patient()
{
    return $this->belongsTo(user::class, 'student_number', 'student_number');
}

public function treatment()
{
    return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
}

// public function patient()
// {
//     return $this->belongsTo(User::class, 'patient_id'); // 'patient_id' links to User table
// }

// public function treatment()
// {
//     return $this->belongsTo(Treatment::class, 'treatment_id'); // 'treatment_id' links to Treatment table
// }

}
