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
