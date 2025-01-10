<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'roles',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}