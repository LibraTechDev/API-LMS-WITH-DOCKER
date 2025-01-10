<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'video_url',
        'file_attachment',
        'course_id',
        'parent_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function parent()
    {
        return $this->belongsTo(CourseContent::class, 'parent_id');
    }
}