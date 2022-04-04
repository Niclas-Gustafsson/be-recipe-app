<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe_list extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe',
        'recipe_id',
        'image',
        'user_list_id',

    ];


    public function user_lists()
    {
        return $this->belongsTo(User_lists::class, 'id');
    }
}
