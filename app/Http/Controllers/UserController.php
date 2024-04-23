<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers()
    {
        try {
            $user = User::all();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Users retrieved successfully",
                    "data" => $user,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Users retrieved unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function createUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:50',
                'nickName' => 'required|max:50',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $user = new User();
            $user->name = $request->input('name');
            $user->nickName = $request->input('nickName');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User created successfully",
                    "data" => $user,
                ],
                201 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User created unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }
    
    public function updateUserById($id, Request $request)
    {
        try {
            $user = User::find($id);
            $name = $request->input('name');
            $nickName = $request->input('nickName');
            $email = $request->input('email');
            $password = $request->input('password');
            
            if ($name){
                $user->name = $name;
            }

            if ($nickName){
                $user->nickName = $nickName;
            }
            if ($email){
                $user->email = $email;
            }
            if ($password){
                $user->password = $password;
            }
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated successfully",
                    "data" => $user,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User updated unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }

    }

    public function deleteUserById($id)
    {
        try {
            $user = User::find($id);
            $user->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User deleted successfully",
                    "data" => $user,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User deleted unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

}
