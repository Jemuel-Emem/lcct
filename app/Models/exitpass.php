<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exitpass extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_number',

        'qr',
        'destination',
        'responsible_person',
        'relationship_to_student',
        'exit_date',
        'exit_time'
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_number', 'student_number');
    }

}
