<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'status',
    ];

    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'notice_notice_category', 'category_id', 'notice_id');
    }
}
