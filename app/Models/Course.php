<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
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

    protected static function booted(): void
    {
        static::saving(function (Course $course) {
            // Jika slug dirty tapi kosong/blank, set ke null agar masuk logic generate dari title
            if ($course->isDirty('slug') && blank($course->slug)) {
                $course->slug = null;
            }

            // Jika slug dirty dan ada isinya, pastikan unique
            if ($course->isDirty('slug') && filled($course->slug)) {
                $course->slug = $course->makeSlugUnique($course->slug);
                return;
            }

            // Jika slug masih blank, generate dari title
            if (blank($course->slug)) {
                $course->slug = $course->generateUniqueSlugFromTitle($course->title);
            }
        });
    }

    protected function generateUniqueSlugFromTitle(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'course';

        return $this->makeSlugUnique($baseSlug);
    }

    protected function makeSlugUnique(string $baseSlug): string
    {
        $base = trim($baseSlug) !== '' ? $baseSlug : 'course';
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($this->exists, fn ($query) => $query->where('id', '!=', $this->id))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function setSlugAttribute($value): void
    {
        // Ubah empty string jadi null agar logic blank() berfungsi dengan benar
        $slugified = Str::slug($value);
        $this->attributes['slug'] = filled($slugified) ? $slugified : null;
    }

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
