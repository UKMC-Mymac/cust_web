<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id', 'title', 'description', 'date', 'attach', 'status', 'created_by', 'updated_by',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
}
