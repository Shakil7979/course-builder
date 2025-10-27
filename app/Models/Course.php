<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'feature_video_path',
        'feature_video_original_name'
    ];

    /**
     * Get the modules for the course.
     */
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    /**
     * Get the feature video URL.
     */
    public function getFeatureVideoUrlAttribute()
    {
        return $this->feature_video_path ? asset('storage/' . $this->feature_video_path) : null;
    }

    /**
     * Get the total contents count for the course.
     */
    public function getTotalContentsAttribute()
    {
        return $this->modules->sum(function($module) {
            return $module->contents->count();
        });
    }

    /**
     * Scope a query to only include popular courses.
     */
    public function scopePopular($query)
    {
        return $query->where('category', 'popular');
    }
}