<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalRecord extends Model
{
    use HasFactory;
    protected $fillable = ['student_number', 'name', 'document_path'];


}
