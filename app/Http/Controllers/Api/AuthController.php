<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\User;
use OpenApi\Annotations as OA;

/**
 * Class AuthController.
 * @author Nikeisha <nikeisha.422024026@ukrida.ac.id>
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     tags={"user"},
     *     summary="Register new user & get token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             example={
     *                 "name": "Ada Lovelace",
     *                 "email": "ada.lovelace@gmail.com",
     *                 "password": "Password123",
     *                 "password_confirmation": "Password123"
     *             }
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful registration"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // Membutuhkan field 'password_confirmation'
        ]);

        if ($validator->fails()) {
            // PERUBAHAN DI SINI: Kirim semua pesan error, bukan hanya yang pertama.
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     tags={"user"},
     *     summary="Log in and receive token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(example={"email": "ada.lovelace@gmail.com", "password": "Password123"})
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=400, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6', // Password harus minimal 6 karakter
        ]);

        if ($validator->fails()) {
            // PERUBAHAN DI SINI: Kirim semua pesan error, bukan hanya yang pertama.
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401); // Sebaiknya 401 untuk kredensial salah
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/user/logout",
     *     tags={"user"},
     *     summary="Logout and revoke token",
     *     security={{"passport":{}}},
     *     @OA\Response(response=200, description="Logout successful"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'You have been successfully logged out!'], 200);
    
    }
}
