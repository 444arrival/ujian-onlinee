<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'title',
        'start_time',
        'end_time',
        'duration',
        'is_active', 
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'exam_id');
    }

    public function getStatusAttribute()
{
    $start = Carbon::parse($this->start_time);
    $end   = $start->copy()->addMinutes($this->duration);
    // $end   = $start->copy()->addMinutes(30); 

    if (now()->lt($start)) {
        return 'Belum Dimulai';
    }

    if (now()->between($start, $end)) {
        return 'Sedang Berlangsung';
    }

    return 'Selesai';
}
}
