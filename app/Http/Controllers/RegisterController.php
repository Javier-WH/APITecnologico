<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\FindUserRequest;
use App\Http\Requests\UpdatePartialUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ApiUserInfo;
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

    public function show(FindUserRequest $request)
    {
        $request->validated();
        $id = $request->query("id");
        $userData = User::find($id);

        $userInfo = ApiUserInfo::where("user_id", $id)
        ->select("first_name", "last_name", "ci", "email", "phone", "address", "description")
        ->first();

        $data = [
            "id" => $userData->id,
            "user" => $userData->user,
            "level" => $userData->level,
        ];

        $responseData = array_merge($data, $userInfo ? $userInfo->toArray() : []);

        return jsonResponse(data: $responseData, message: "OK", status: 200);
    }

    public function delete(FindUserRequest $request)
    {
        $request->validated();
        //la API no puede quedar sin administradores
        if (User::where('level', 1)->count() == 1) {
            return jsonResponse(message: "La API solo tiene un administrador", status: 403, errors: ["error" => "No se puede borrar el administrador"]);
        }

        $userData = User::find($request->id);
        $userData->delete();
        return jsonResponse(data: ["user_id" => $request->id], message: "User deleted", status: 201);
    }

    public function update(UpdateUserRequest $request)
    {
        $userData = User::find($request->id);
        $userData->user = $request->user;
        $userData->password = $request->password;
        $userData->level = $request->level ?? $userData->level; // si no viene el level, se mantendra el actual
        $userData->save();
        return jsonResponse(data: ["user_id" => $request->id], message: "User updated", status: 201);
    }

    public function updatePartial(UpdateUserRequest $request)
    {
        $userData = User::find($request->id);
        $userData->user = $request->filled('user') ? $request->user : $userData->user;
        $userData->password = $request->filled('password') ? $request->password : $userData->password;
        $userData->level = $request->filled('level') ? $request->level : $userData->level;
        $userData->save();
        return jsonResponse(data: ["user_id" => $request->id], message: "User updated", status: 201);
    }


}
