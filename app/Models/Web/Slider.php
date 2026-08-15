<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'title', 'sub_title', 'button_text', 'button_link', 'page_id', 'route_name', 'button_text_2', 'button_link_2', 'page_id_2', 'route_name_2', 'attach', 'video_url', 'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
