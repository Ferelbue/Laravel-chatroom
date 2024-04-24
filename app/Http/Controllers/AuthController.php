<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            Log::info("Registering user" . $request->input('name'));

            //Recuperar info
            $name = $request->input('name');
            $nickname = $request->input('nickname');
            $email = $request->input('email');
            $password = $request->input('password');


            //validar info
            // $request->validate([
            //     'name' => 'required|string',
            //     'nickname' => 'required|string',
            //     'email' => 'required|email',
            //     'password' => 'required'
            // ]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users|max:50',
                'nickname' => 'required|string',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'Validation error',
                        'error' => $validator->errors()
                    ],
                    400
                );
            }

            // Tratar info
            $hashPassword = bcrypt($password);

            //Guardar info
            $newUser = new User();

            $newUser->name = $name;
            $newUser->nickname = $nickname;
            $newUser->email = $email;
            $newUser->password = $hashPassword;

            $newUser->save();

            //Enviar respuesta

            return response()->json(
                [
                    'succes' => true,
                    'message' => 'User registered successfully',
                    'data' => $newUser
                ],
                201
            );
        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'User registered UNsuccessfully',
                    'error' => $th->getMessage()
                ],
                500
            );
        }
    }

    public function login(Request $request)
    {
        try {
            Log::info("Logging in user" . $request->input('email'));

            //Recuperar info
            $email = $request->input('email');
            $password = $request->input('password');

            //validar info
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'Validation error',
                        'error' => $validator->errors()
                    ],
                    400
                );
            }

            //Buscar usuario
            $user = User::where('email', $email)->firstOrfail();

            if (!$user) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'User not found',
                        'error' => 'User not found'
                    ],
                    404
                );
            }

            //Comprobar contraseña
            $checkPasswordUser = Hash::check($password, $user->password);

            if (!$checkPasswordUser) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Invalid password',
                        'error' => 'Invalid password'
                    ],
                    401
                );
            }

            //Generar token
            $token = $user->createToken('auth_token')->plainTextToken;

            //Enviar respuesta
            return response()->json(
                [
                    'succes' => true,
                    'message' => 'User logged in successfully',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ],
                200
            );
        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Email or password incorrect',
                    'error' => $th->getMessage()
                ],
                400
            );
        }
    }

    public function getProfile()
    {
        try {

            $user = auth()->user();

            return response()->json(
                [
                    'succes' => true,
                    'message' => 'User profile',
                    'data' => $user
                ],
                200
            );
        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error retrieving user profile',
                    'error' => $th->getMessage()
                ],
                500
            );
        }
    }
}
