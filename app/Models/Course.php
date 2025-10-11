<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instructor',
        'description',
        'price',
        'thumbnail',
        'trailer_video_id',
        'full_video_ids',
        'course_category_id',
        'level',
    ];

    protected $casts = [
        'full_video_ids' => 'array',
    ];

    /**
     * Get the users enrolled in this course
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'enrollments')
                    ->withPivot('payment_status', 'status', 'enrolled_at', 'payment_method', 'payment_proof')
                    ->withTimestamps();
    }

    /**
     * Get the enrollments for this course
     */
    public function enrollments()
    {
        return $this->hasMany(\App\Models\Enrollment::class);
    }

    /**
     * Get the lessons for this course
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }
}
