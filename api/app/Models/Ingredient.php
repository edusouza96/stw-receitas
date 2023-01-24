<?php

namespace App\Models;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;
    protected $table = "ingredients";
    protected $fillable = ['description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipes_ingredients');
    }

    public function canDestroy()
    {
        return $this->recipes->isEmpty();
    }
}
