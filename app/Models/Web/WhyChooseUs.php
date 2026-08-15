<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class WhyChooseUs extends Model
{
    use HasFactory;
    protected $table = 'why_choose_us';
    protected $fillable = [
        'items', 'status', 'attach','url', 'button_text', 'language_id'
    ];

    protected $casts = [
        'items' => 'json',
        'status' => 'integer',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}