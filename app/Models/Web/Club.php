<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs';

    protected $fillable = [
        'title', 'icon', 'page_id', 'route_name', 'link',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
