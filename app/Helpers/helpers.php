<?php

use App\Models\User;

//formatea las respuestas de la api para que sean consistentes
function jsonResponse($data = [], $status = 200, $message = 'OK', $errors = []){
  return response()->json(compact("data", "status", "message", "errors"), $status);
}

// comprueba el nivel del usuario
function validadateLevel($payload, $type): bool{
  try {

    $id = $payload->get('id');
    $level = $payload->get('level');
    $userName = $payload->get('user');

    $user = User::find($id);

    //valida que los datos en el payload sean igual que los datos en la base de datos
    if($user->id !== $id){
      return false;
    }
    if($user->user !== $userName){
      return false;
    }
    if($user->level !== $level){
      return false;
    }

    //si el usuario es de tipo 1, el level tiene que ser 1
    if($type === 1 && $level !== 1){
      return false;
    }
    //si el usuario es de tipo 2, el level tiene que ser 1 o 2
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
