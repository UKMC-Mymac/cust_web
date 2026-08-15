<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class CampusLife extends Model
{
    use HasFactory;
    protected $table = 'campus_lives';

    protected $fillable = [
        'title','feature_text','slug','description','status', 'attach','button_text', 'sort_order', 'language_id'
    ];

     public function language(){
        return $this->belongsTo(Language::class,'language_id');
    }
}