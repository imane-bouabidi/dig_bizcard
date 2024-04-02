<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *     title="Digital card API",
 *     version="1.0.0",
 *     description="This API allows users to create, update, and delete business cards."
 * )
 */


class AuthController extends Controller
{
    // Inscription (register) d'un nouvel utilisateur
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Inscription d'un nouvel utilisateur",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password", minLength=8),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur enregistré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
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
     *         description="Erreur lors de l'inscription de l'utilisateur",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     * )
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to register user'], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Connexion de l'utilisateur",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur connecté avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Identifiants invalides",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     * )
     */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json(['message' => 'User logged in successfully', 'user' => $user, 'token' => $token]);
    }


    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Déconnexion de l'utilisateur",
     *     tags={"Auth"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur déconnecté avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'User logged out successfully']);
    }
}
