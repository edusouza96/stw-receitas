<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Resources\RecipeIngredientsResource;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => $recipes->map(function($recipe){ return new RecipeIngredientsResource($recipe); }),
            'message' => '',
            'success' => true
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $recipe = Recipe::create([
                "name" => $request->name
            ]);

            foreach ($request->ingredients as $ingredients) {
                $recipe->ingredients()->attach($ingredients['id'], [
                    "kg" => $ingredients['kg'],
                    "order" => $ingredients['order'],
                ]);
            }

            return response()->json([
                'message' => 'Receita adicionado com sucesso',
                'success' => true
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'success' => false
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);

        return response()->json([
            'data' => new RecipeIngredientsResource($recipe),
            'message' => '',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
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

            return response()->json([
                'message' => 'Receita atualizada com sucesso',
                'success' => true
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'success' => false
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
