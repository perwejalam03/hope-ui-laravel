<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Video extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = [
        'title',
        'thumbnail',
        'category',
        'description',
        'status',
        'media',
        'cp_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }


}

