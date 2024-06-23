<?php

namespace App\Http\Controllers;

use App\Http\Requests\setUserInfoRequest;
use App\Http\Requests\updateUserInfoRequest;
use App\Models\ApiUserInfo;
use Illuminate\Http\Request;

class ApiUserInfoController extends Controller
{

    public function setUserInfo(setUserInfoRequest $request){
        ApiUserInfo::create($request->all());
        return jsonResponse(status: 201);
    }

    public function updateInfo(updateUserInfoRequest $request){
        $userId = $request->query('id');

        if(!$userId){
            return jsonResponse(status: 400, message: 'No se ha enviado el identificador del usuario.');
        }

        $user = ApiUserInfo::where('user_id', $userId)->first();
        if(!$user){
            return jsonResponse(status: 404, message: 'No se ha encontrado el usuario.');
        }

        $data = $request->all();
        $user = ApiUserInfo::where('user_id', $userId)->first();
        $user->update($data);
        return jsonResponse(status: 204);
    }
}
