<?php

namespace App\Models\Web;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model
{
    use HasFactory;

    protected $table = 'content_sections';

    protected $fillable = [
        'language_id',
        'key',
        'section_name',
        'subtitle',
        'title',
        'description',
        'status'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
