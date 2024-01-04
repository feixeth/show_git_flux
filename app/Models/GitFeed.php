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
    ];

}
