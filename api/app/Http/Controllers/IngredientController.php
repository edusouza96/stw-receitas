<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredients = Ingredient::orderBy('description', 'asc')->get();

        return response()->json([
            'data' => $ingredients,
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
            Ingredient::create([
                "description" => $request->description
            ]);

            return response()->json([
                'message' => 'Ingrediente adicionado com sucesso',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $ingredient = Ingredient::find($id);
            if(!$ingredient) throw new \Exception("ID do ingrediente informado não existe", 1);

            $ingredient->description = $request->description;
            $ingredient->save();

            return response()->json([
                'message' => 'Ingrediente atualizado com sucesso',
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
            $ingredient = Ingredient::find($id);
            if(!$ingredient) throw new \Exception("ID do ingrediente informado não existe", 1);
            if(!$ingredient->canDestroy()) throw new \Exception("Não pode remover o ingrediente, pois o mesmo é usado em outras receitas", 1);

            Ingredient::destroy($id);

            return response()->json([
                'message' => 'Ingrediente removido com sucesso',
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
