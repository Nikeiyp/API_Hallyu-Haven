<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use OpenApi\Annotations as OA;


/**
 * Class AuthController.
 * 
 * @author nikeisha.422024026@gmail.com
 */

class AuthController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/user/register",
 *     tags={"User"},
 *     summary="Register user baru",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="IU"),
 *             @OA\Property(property="email", type="string", example="iu@kpop.com"),
 *             @OA\Property(property="password", type="string", example="secure123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User berhasil didaftarkan",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User registered")
 *         )
 *     )
 * )
 */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered',
        ]);
    }

    /**
 * @OA\Post(
 *     path="/api/user/login",
 *     tags={"User"},
 *     summary="Login dan dapatkan access token",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="iu@kpop.com"),
 *             @OA\Property(property="password", type="string", example="secure123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Token berhasil dikembalikan",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK...")
 *         )
 *     )
 * )
 */


    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('MyAppToken')->accessToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
 * @OA\Post(
 *     path="/api/user/logout",
 *     tags={"User"},
 *     summary="Logout user",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Logout berhasil",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Logged out")
 *         )
 *     )
 * )
 */

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    public function whoami(Request $request)
    {
        return response()->json($request->user());
    }
}
