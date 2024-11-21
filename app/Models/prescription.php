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
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
