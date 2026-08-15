<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomUrl extends Model
{
    protected $table = 'custom_urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'title', 'page_id', 'route_name', 'url', 'status',
    ];

    public function page()
    {
        return $this->belongsTo(\App\Models\Web\Page::class, 'page_id');
    }

    /**
     * Get the resolved URL.
     *
     * @return string
     */
    public function getResolvedUrlAttribute()
    {
        $linkHref = $this->url;
        if (empty($linkHref) && !empty($this->page_id)) {
            $page = $this->page;
            $linkHref = $page ? url('page/' . ($page->slug ?? $page->id)) : '#';
        } elseif (empty($linkHref) && !empty($this->route_name)) {
            try {
                $linkHref = route($this->route_name);
            } catch (\Exception $e) {
                $linkHref = '#';
            }
        }
        return $linkHref ?? '#';
    }
}
