<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // مهم للتسجيل
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'phone',
        'image',
        'working_hours',
        'email',      // تم إضافته
        'password',   // تم إضافته
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];

    // العلاقة مع المواعيد
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}