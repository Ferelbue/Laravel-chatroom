<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
}
