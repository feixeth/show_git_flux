<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyCouples extends Model
{
    use HasFactory;

    protected $table = 'key_couples';

    protected $primaryKey = 'id';

    protected $fillable = [
        'githubkey',
        'gitlabkey'
    ];


    // define relation with the key_couples
    public function keyCouple()
    {
        return $this->belongTo(keyCouple::class,'key_couple_id');
    }
}
