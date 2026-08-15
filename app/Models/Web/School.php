<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class School extends Model
{
    use HasFactory;

    protected $table = 'web_schools';

    protected $fillable = [
        'language_id', 'title', 'slug', 'short_description', 'description', 'attach', 'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'school_id')->where('status', 1);
    }
}
