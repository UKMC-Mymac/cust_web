<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = [
        'serial_no',
        'name',
        'slug',
        'designation',
        'description',
        'status',
    ];

    /**
     * Normalize editor image paths when reading stored member content.
     */
    public function getDescriptionAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*["\'])([^"\']+)(["\'][^>]*>)/i', function ($matches) {
            $src = $matches[2];
            $path = parse_url($src, PHP_URL_PATH) ?: $src;

            if (preg_match('#^(?:\./|\.\./)*(uploads/.*)$#i', ltrim($path, '/'), $relativeMatch)) {
                return $matches[1].'/'.$relativeMatch[1].$matches[3];
            }

            if (preg_match('#^/+(uploads/.*)$#i', $path, $absoluteMatch)) {
                return $matches[1].'/'.$absoluteMatch[1].$matches[3];
            }

            return $matches[0];
        }, $value);
    }
}