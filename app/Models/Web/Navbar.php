<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Web\Page;

class Navbar extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'parent_id',
        'page_id',
        'route_name',
        'label',
        'url',
        'target',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function childrenRecursive()
    {
        return $this->children()->with(['childrenRecursive', 'page']);
    }

    public function activeChildren()
    {
        return $this->hasMany(self::class, 'parent_id')->where('status', 1)->orderBy('sort_order');
    }

    public function activeChildrenRecursive()
    {
        return $this->activeChildren()->with(['activeChildrenRecursive', 'page']);
    }
}
