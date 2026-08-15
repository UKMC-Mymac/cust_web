<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Department extends Model
{
    use HasFactory;

    protected $table = 'web_departments';

    protected $fillable = [
        'school_id', 'language_id', 'title', 'slug', 'short_description', 'attach', 'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id')->where('status', 1);
    }
}
