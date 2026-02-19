<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Result;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id', 'student_id', 'total_score', 'status'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'exam_id', 'exam_id')
                    ->where('student_id', $this->student_id);
    }
}
