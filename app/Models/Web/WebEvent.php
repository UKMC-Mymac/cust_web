<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class WebEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'title', 'slug', 'date', 'time', 'address', 'description','feature_text', 'attach', 'status', 'pinned',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}