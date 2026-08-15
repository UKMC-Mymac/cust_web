<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class FooterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'title', 'sort_order', 'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function links()
    {
        return $this->hasMany(FooterLink::class)
                    ->where('status', '1')
                    ->orderBy('sort_order', 'asc');
    }
}
