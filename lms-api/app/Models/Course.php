<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'description',
        'price',
        'image',
        'teacher_id',
        'max_students',
    ];

    public function isFull()
    {
        return $this->max_students && $this->members()->count() >= $this->max_students;
    }

    public function members(): HasMany
    {
        return $this->hasMany(CourseMember::class, 'course_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function isMember($user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id')->where('role', 'teacher');
    }
}