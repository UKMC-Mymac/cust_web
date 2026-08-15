<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'title',
        'subtitle',
        'email',
        'phone',
        'address',
        'description',
        'map_link',
        'status',
    ];
}