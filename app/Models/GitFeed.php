<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GitFeed extends Model
{
    use HasFactory;

    protected $table = 'gitfeed';

    protected $fillable = [
        'generated_url',
        'html_content',
        'key_couple_id'
    ];

    public function keyCouple()
{
    return $this->belongsTo(KeyCouples::class, 'key_couple_id');
}


}
