<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\IngredientSaveRequest;

class IngredientController extends Controller
{

    public function index()
    {
        $ingredients = Ingredient::orderBy('id', 'asc')->get();

        return response()->json([
            'data' => $ingredients,
            'message' => '',
            'success' => true
        ]);
    }


    public function store(IngredientSaveRequest $request)
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


    public function update(IngredientSaveRequest $request, $id)
    {
        try {
            $ingredient = Ingredient::find($id);
            if (!$ingredient) throw new \Exception("ID do ingrediente informado não existe", 1);

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


    public function destroy($id)
    {
        try {
            $ingredient = Ingredient::find($id);
            if (!$ingredient) throw new \Exception("ID do ingrediente informado não existe", 1);
            if (!$ingredient->canDestroy()) throw new \Exception("Não pode remover o ingrediente, pois o mesmo é usado em outras receitas", 1);

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
