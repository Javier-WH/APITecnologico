<?php

use App\Models\User;

function jsonResponse($data = [], $status = 200, $message = 'OK', $errors = []){
  return response()->json(compact("data", "status", "message", "errors"), $status);
}

function validadateLevel($payload, $type): bool{
  try {
    $id = $payload->get('id');
    $level = $payload->get('level');
    $userName = $payload->get('user');
  
    $user = User::find($id);
  
    if($user->id !== $id){
      return false;
    }
    if($user->user !== $userName){
      return false; 
    } 
    if($user->level !== $level){  
      return false;
    } 
    if($type === 1 && $level !== 1){
      return false;
    }
    if($type === 2 && $level > 2){
      return false;
    }
  } catch (\Throwable $th) {
    return false;
  }
  return true;
}


//coloca todos los elementos en minusculas
function normalizeResponseArrayData(array $data)
{
    return array_map(function ($value) {
        if (is_string($value)) {
            return strtolower($value);
        }
        return $value;
    }, $data);
}