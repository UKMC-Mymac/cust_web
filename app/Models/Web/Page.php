<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'title', 'display_text', 'slug', 'description', 'content_html', 'layout_mode', 'builder_sections', 'page_nav_items', 'page_nav_position', 'meta_title', 'meta_description', 'attach', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'builder_sections' => 'array',
        'page_nav_items' => 'array',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
