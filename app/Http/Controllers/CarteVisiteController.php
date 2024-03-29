<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarteVisite;

class CarteVisiteController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'entreprise' => 'required|string',
            'titre' => 'required|string',
            'coordonnees' => 'required|array', 
        ]);

        $carteVisite = CarteVisite::create($validatedData);

        return response()->json($carteVisite, 201);
    }

    public function update(Request $request, $id)
    {
        $carteVisite = CarteVisite::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'string',
            'entreprise' => 'string',
            'titre' => 'string',
            'coordonnees' => 'array', 
        ]);

        $carteVisite->update($validatedData);

        return response()->json($carteVisite, 200);
    }

    public function destroy($id)
    {
        $carteVisite = CarteVisite::findOrFail($id);

        $carteVisite->delete();

        return response()->json(null, 204);
    }
}
