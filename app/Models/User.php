<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nis' 
    ];

    protected $hidden = [
        'password', 
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class, 'teacher_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'student_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'student_id');
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

public function setPasswordAttribute($password)
{

    if (!\Illuminate\Support\Facades\Hash::needsRehash($password)) {
        $this->attributes['password'] = $password;
    } else {
        $this->attributes['password'] = bcrypt($password);
    }
}
}
