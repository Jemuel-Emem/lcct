<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'quantity',

    ];

    public function prescriptions()
{
    return $this->hasMany(Prescription::class);
}

}