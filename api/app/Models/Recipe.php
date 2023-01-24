<?php

namespace App\Models;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;
    protected $table = "recipes";
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipes_ingredients')
            ->orderByPivot('order')
            ->withPivot(['kg', 'order']);
    }

}
