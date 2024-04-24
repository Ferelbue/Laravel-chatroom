<?php

namespace App\Http\Controllers;

use App\Models\User;
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

            //Read info
            $name = $request->input('name');
            $nickname = $request->input('nickname');
            $email = $request->input('email');
            $password = $request->input('password');
            //Validate info
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users|max:50',
                'nickname' => 'required|string',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:6'
            ]);
            //check if validation fails
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

            // Treatment info
            $hashPassword = bcrypt($password);

            //Save info
            $newUser = new User();
            $newUser->name = $name;
            $newUser->nickname = $nickname;
            $newUser->email = $email;
            $newUser->password = $hashPassword;
            $newUser->save();

            //Send response
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
            //Log fill
            Log::info("Logging in user" . $request->input('email'));

            //Read info
            $email = $request->input('email');
            $password = $request->input('password');

            //validate info
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            //check if validation fails
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

            //search usuario
            $user = User::where('email', $email)->firstOrfail();
            //check if user exists
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

            //Cheack password
            $checkPasswordUser = Hash::check($password, $user->password);
            //check if password is correct
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

            //Generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            //Send response
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
            //Read info from autenticated user
            $user = auth()->user();
            //Send response
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

    public function logout(Request $request)
    {
        try {
            // REMOVE TOKEN DATA
            // TODOS LOS TOKENS DEL USER
            $request->user()->tokens()->delete();
            // TOKEN ACTUAL
            // $request->user()->currentAccessToken()->delete();

            //Send response
            return response()->json(
                [
                    'succes' => true,
                    'message' => 'User logged out successfully'
                ],
                200
            );
        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error logging out user',
                    'error' => $th->getMessage()
                ],
                500
            );
        }
    }
}