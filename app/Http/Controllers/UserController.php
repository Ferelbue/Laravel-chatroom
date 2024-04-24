<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers(Request $request)
    {
        try {
            // Read query parameters
            $query = User::query();

            // Filter by name
            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }
            // Filter by email
            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->input('email') . '%');
            }

            // Pagination and limit
            $limit = $request->input('limit', 10);
            $users = $query->paginate($limit);

            // Check if users are empty
            if ($users->isEmpty()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "No users found",
                    ],
                    404
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Users retrieved successfully",
                    "data" => $users,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "An error occurred",
                    "error" => $th->getMessage(),
                ],
                500
            );
        }
    }

    public function createUser(Request $request)
    {
        try {
            //validate request
            $validator = $request->validate([
                'name' => 'required|max:50',
                'nickName' => 'required|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            //hash password
            $password = $request->input('password');
            $hashPassword = bcrypt($password);

            //create user
            $user = new User();
            $user->name = $request->input('name');
            $user->nickName = $request->input('nickName');
            $user->email = $request->input('email');
            $user->password = $hashPassword;;
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User created successfully",
                    "data" => $user,
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "An error occurred",
                    "error" => $th->getMessage(),
                ],
                500
            );
        }
    }

    public function updateUserById($id, Request $request)
    {
        try {
            // Find user by id
            $user = User::find($id);

            // Read request data
            $name = $request->input('name');
            $nickName = $request->input('nickName');
            $email = $request->input('email');
            $password = $request->input('password');

            // Check if all data are received
            if ($name) {
                $user->name = $name;
            }
            if ($nickName) {
                $user->nickName = $nickName;
            }
            if ($email) {
                $user->email = $email;
            }
            if ($password) {
                $user->password = $password;
            }
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated successfully",
                    "data" => $user,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "An error occurred",
                    "error" => $th->getMessage(),
                ],
                500
            );
        }
    }

    public function deleteUserById($id)
    {
        try {
            // Find user by id
            $user = User::find($id);

            // Check if user exists
            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found",
                    ],
                    404
                );
            }
            //Delete user
            $user->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User deleted successfully",
                    "data" => $user,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "An error occurred",
                    "error" => $th->getMessage(),
                ],
                500
            );
        }
    }
}
