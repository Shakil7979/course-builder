<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order'
    ];

    /**
     * Get the course that owns the module.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the contents for the module.
     */
    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    /**
     * Get the contents count for the module.
     */
    public function getContentsCountAttribute()
    {
        return $this->contents->count();
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($module) {
            // Delete all contents when module is deleted
            $module->contents()->delete();
        });
    }
}