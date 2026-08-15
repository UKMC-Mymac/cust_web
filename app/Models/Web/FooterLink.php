<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_section_id', 'label', 'url', 'page_id', 'route_name', 'sort_order', 'status',
    ];

    public function section()
    {
        return $this->belongsTo(FooterSection::class, 'footer_section_id');
    }

    public function page()
    {
        return $this->belongsTo(\App\Models\Web\Page::class, 'page_id');
    }
}
