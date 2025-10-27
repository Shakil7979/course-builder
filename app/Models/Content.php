<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'type',
        'content',
        'file_path',
        'file_original_name',
        'order'
    ];

    /**
     * Content type constants
     */
    const TYPE_TEXT = 'text';
    const TYPE_VIDEO = 'video';
    const TYPE_IMAGE = 'image';
    const TYPE_LINK = 'link';

    /**
     * Get the module that owns the content.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the file URL attribute.
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    /**
     * Check if content has a file.
     */
    public function getHasFileAttribute()
    {
        return !is_null($this->file_path);
    }

    /**
     * Get the file type attribute.
     */
    public function getFileTypeAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        $extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
        
        if (in_array($extension, ['mp4', 'avi', 'mov', 'wmv'])) {
            return 'video';
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return 'image';
        }

        return 'unknown';
    }

    /**
     * Scope a query to only include specific type of contents.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include contents with files.
     */
    public function scopeWithFiles($query)
    {
        return $query->whereNotNull('file_path');
    }
}