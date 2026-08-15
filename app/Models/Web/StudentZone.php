<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentZone extends Model
{
    use HasFactory;

    protected $table = 'student_zones';

    protected $fillable = [
        'title', 'icon_url', 'page_id', 'route_name', 'link', 'order', 'status',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
