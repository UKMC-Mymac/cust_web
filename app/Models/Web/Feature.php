<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'title', 'category', 'program_language', 'duration', 'button_text', 'button_url', 'description', 'icon', 'attach', 'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}