<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeHistory extends Model
{
    protected $table = "recipes_histories";
    protected $fillable = ['recipe_id', 'content'];
    protected $hidden = ['created_at', 'updated_at'];
}
