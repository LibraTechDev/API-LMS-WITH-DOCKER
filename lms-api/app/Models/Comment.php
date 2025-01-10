<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'content_id',
        'member_id',
        'comment',
    ];

    public function course()
    {
        return $this->belongsTo(CourseContent::class, 'course_id');
    }
    
    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'content_id');
    }

    public function member()
    {
        return $this->belongsTo(CourseMember::class, 'member_id');
    }
}