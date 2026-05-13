<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighlightTab extends Model
{
    protected $fillable = ['name', 'slug', 'position', 'active'];

    public function highlights()
    {
        return $this->hasMany(Highlight::class);
    }
}
