<?php

use App\Models\User;

/**
 * formatea las respuestas de la api para que sean consistentes
 *
 * Return a JSON response with a consistent structure.
 * @param array $data The data to be returned.
 * @param int $status The HTTP status code.
 * @param string $message A custom message.
 * @param array $errors An array with errors.
 * @return \Illuminate\Http\JsonResponse The JSON response.
 */
function jsonResponse($data = [], $status = 200, $message = 'OK', $errors = []){
  return response()->json([
    'data' => $data,
    'status' => $status,
    'message' => $message,
    'errors' => $errors,
  ], $status);
}


/**
 * Comprueba el nivel del usuario basado en el payload
 *
 * @param mixed $payload The user data payload.
 * @param int $type The type of user.
 * @return bool Returns true if the user level is valid, false otherwise.
 */
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



/**
 * Coloca todos los elementos en minusculas, se utiliza para normalizar la respuesta de la api, debido a que las tablas no estan normalizadas.
 *
 * @param array $data The array to be normalized.
 * @return array The normalized array.
 */
function normalizeResponseArrayData(array $data)
{
    return array_map(function ($value) {
        if (is_string($value)) {
            return strtolower($value);
        }
        return $value;
    }, $data);
}
