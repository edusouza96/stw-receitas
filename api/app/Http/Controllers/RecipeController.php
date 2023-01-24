<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\RecipeHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RecipeSaveRequest;
use App\Http\Resources\RecipeIngredientsResource;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => $recipes->map(function($recipe){ return new RecipeIngredientsResource($recipe); }),
            'message' => '',
            'success' => true
        ]);
    }


    public function store(RecipeSaveRequest $request)
    {
        try {
            DB::beginTransaction();
            $recipe = Recipe::create([
                "name" => $request->name
            ]);

            foreach ($request->ingredients as $ingredients) {
                $recipe->ingredients()->attach($ingredients['id'], [
                    "kg" => $ingredients['kg'],
                    "order" => $ingredients['order'],
                ]);
            }

            RecipeHistory::create([
                "recipe_id" => $recipe->id,
                "content" => json_encode($request->all()),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Receita adicionado com sucesso',
                'success' => true
            ]);

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => $ex->getMessage(),
                'success' => false
            ]);
        }
    }


    public function show($id)
    {
        $recipe = Recipe::find($id);

        return response()->json([
            'data' => new RecipeIngredientsResource($recipe),
            'message' => '',
            'success' => true
        ]);
    }


    public function update(RecipeSaveRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $recipe = Recipe::find($id);
            if(!$recipe) throw new \Exception("ID da Receita informada não existe", 1);

            $recipe->name = $request->name;
            $recipe->save();

            $recipe->ingredients()->detach();
            foreach ($request->ingredients as $ingredients) {
                $recipe->ingredients()->attach($ingredients['id'], [
                    "kg" => $ingredients['kg'],
                    "order" => $ingredients['order'],
                ]);
            }

            RecipeHistory::create([
                "recipe_id" => $recipe->id,
                "content" => json_encode($request->all()),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Receita atualizada com sucesso',
                'success' => true
            ]);

        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'message' => $ex->getMessage(),
                'success' => false
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            Recipe::destroy($id);

            return response()->json([
                'message' => 'Receita removida com sucesso',
                'success' => true
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'success' => false
            ]);
        }
    }
}
