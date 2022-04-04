<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_lists extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
    ];

    public function recipe_list()
    {
        return $this->hasMany(Recipe_list::class, "user_list_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
