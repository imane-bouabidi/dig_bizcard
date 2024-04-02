<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarteVisite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/**
 * @OA\Schema(
 *     schema="CarteVisite",
 *     required={"id", "nom", "tel", "entreprise", "title", "coordonnees", "description"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="John Doe"),
 *     @OA\Property(property="tel", type="string", example="123-456-7890"),
 *     @OA\Property(property="entreprise", type="string", example="XYZ Company"),
 *     @OA\Property(property="title", type="string", example="CEO"),
 *     @OA\Property(property="coordonnees", type="string", example="123 Main Street, City, Country"),
 *     @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
 * )
 */
/**
 * @OA\Schema(
 *     schema="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 * )
 */
class CarteVisiteController extends Controller
{

/**
     * @OA\Get(
     *     path="/cartes-visites",
     *     summary="Récupérer toutes les cartes de visite de l'utilisateur",
     *     tags={"Cartes de visite"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des cartes de visite de l'utilisateur",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CarteVisite")
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $cartes = CarteVisite::where('user_id',Auth::user()->id)->get();
        return response()->json($cartes, 201);
    }

/**
     * @OA\Post(
     *     path="/cartes-visites",
     *     summary="Créer une nouvelle carte de visite",
     *     tags={"Cartes de visite"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "tel", "entreprise", "titre", "coordonnees", "description"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="entreprise", type="string"),
     *             @OA\Property(property="titre", type="string"),
     *             @OA\Property(property="coordonnees", type="string"),
     *             @OA\Property(property="description", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Carte de visite créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="carteVisite", type="object", ref="#/components/schemas/CarteVisite"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de la création de la carte de visite",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *         ),
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'tel' => 'required',
            'entreprise' => 'required|string',
            'titre' => 'required|string',
            'coordonnees' => 'required', 
            'description' => 'required', 
        ]);
    
        try {
            $carteVisite = CarteVisite::create([
                'user_id' => Auth::user()->id,
                'nom' => $validatedData['nom'],
                'tel' => $validatedData['tel'],
                'entreprise' => $validatedData['entreprise'],
                'titre' => $validatedData['titre'],
                'coordonnees' => $validatedData['coordonnees'],
                'description' => $validatedData['description'],
            ]);
    
            return response()->json($carteVisite, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
/**
     * @OA\Put(
     *     path="/cartes-visites/{id}",
     *     summary="Mettre à jour une carte de visite",
     *     tags={"Cartes de visite"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la carte de visite",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="entreprise", type="string"),
     *             @OA\Property(property="titre", type="string"),
     *             @OA\Property(property="coordonnees", type="string"),
     *             @OA\Property(property="description", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Carte de visite mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="carteVisite", type="object", ref="#/components/schemas/CarteVisite"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Carte de visite non trouvée",
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        $carteVisite = CarteVisite::findOrFail($id);

        // $validator = Validator::make($request->all(), [
        //     'nom' => 'string',
        //     'tel' => 'string',
        //     'entreprise' => 'string',
        //     'titre' => 'string',
        //     'coordonnees' => 'string',
        //     'description' => 'string',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        // $carteVisite->update($request->all());
        // return response()->json($carteVisite, 200);
        // try {
        //     $carteVisite->update($request->all());
        //     return $carteVisite;
        // }catch (\Throwable $th) {
        //     return response()->json(['error' => $th->getMessage()], 500);
        // }
        return $request->all();

        // return response()->json($carteVisite, 200);
    }


    /**
     * @OA\Delete(
     *     path="/cartes-visites/{id}",
     *     summary="Supprimer une carte de visite",
     *     tags={"Cartes de visite"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la carte de visite",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Carte de visite supprimée avec succès",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Non autorisé: Vous n'avez pas la permission de supprimer cette carte de visite",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Carte de visite non trouvée",
     *     ),
     * )
     */
    public function destroy($id)
    {
        $carteVisite = CarteVisite::findOrFail($id);
        if($carteVisite->user_id == Auth::user()->id){
            $carteVisite->delete();
            return response()->json(null, 204);
        }else{
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized: You do not have permission to update this visit card'
            ], 403);
        }

    }
}
