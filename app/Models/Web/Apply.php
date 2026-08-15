<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Apply extends Model
{
    use HasFactory;
    protected $table = 'applies';
    protected $fillable = ['items', 'attach', 'url', 'button_text', 'description', 'language_id', 'status', 'page_id', 'route_name'];
    protected $casts = [
      'items' => 'json',
    ];
    
    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }
}