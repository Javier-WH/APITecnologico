<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;

use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        $userId = Str::uuid();
        User::create([
            'id' => $userId,
            'user' => $request->user,
            'password' => $request->password,
            'level' => $request->level,
        ]);

        return jsonResponse(data: ["user_id" => $userId], message: "User created", status: 201);
    }

    public function show(Request $request)
    {
        try {
            $id = $request->query("id");
            $userData = User::find($id);
            $data =[
                "id" => $userData->id,
                "user" => $userData->user,
                "level" => $userData->level
            ];
            return jsonResponse(data: $data, message: "OK", status: 200);
       
        } catch (\Throwable $th) {
            return jsonResponse(message: "User not found", status: 404);
        }
    }

    public function update(CreateUserRequest $request)
    {
        try {
            $userData = User::find($request->id);
            $userData->user = $request->user;
            $userData->password = $request->password;
            $userData->level = $request->level;
            $userData->save();
            return jsonResponse(data: ["user_id" => $request->id], message: "User updated", status: 201);

        } catch (\Throwable $th) {
            return jsonResponse(message: "User not found", status: 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            $userData = User::find($request->id);
            $userData->delete();
            return jsonResponse(data: ["user_id" => $request->id], message: "User deleted", status: 201);

        } catch (\Throwable $th) {
            return jsonResponse(message: "User not found", status: 404);
        }
    }
}
