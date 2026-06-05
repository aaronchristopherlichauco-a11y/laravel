<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_name',
        'subject_code',
        'instructor',
        'room',
        'day',
        'start_time',
        'end_time',
        'semester',
        'school_year',
        'color',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationAttribute(): string
    {
        return $this->start_time . ' - ' . $this->end_time;
    }
}
