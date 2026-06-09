<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    protected $fillable = [
        'highlight_tab_id',
        'position',
        'title',
        'subtitle',
        'image_path',
        'link_url',
        'active',
    ];

    public function highlightTab()
    {
        return $this->belongsTo(HighlightTab::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/placeholder.webp'); // Or some default
        }
        
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }
}
