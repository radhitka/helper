<?php

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('respondWithToken')) {

    function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer'
        ], Response::HTTP_OK);
    }
}

if (!function_exists('responseJson')) {

    function responseJson($response, $http = Response::HTTP_OK)
    {
        return response()->json($response, $http)
            ->header('Content-Type', 'application/json');
    }
}

if (!function_exists('responseSuccess')) {

    function responseSuccess(string|array $body = [], $http = Response::HTTP_OK)
    {
        if (is_string($body)) {
            $body = ['status' => true, 'message' => $body];
        } elseif (array_key_exists("status", $body) && array_key_exists("message", $body)) {
            $body = $body;
        } else {
            $body = array_merge(['status' => true, 'message' => 'Success'], $body);
        }

        $body = array_merge(['status_code' => $http, 'status_message' => Response::$statusTexts[$http]], $body);

        return responseJson($body, $http);
    }
}

if (!function_exists('responseSuccessOk')) {

    function responseSuccessOk(string|array $body = [])
    {
        return responseSuccess($body, Response::HTTP_OK);
    }
}

if (!function_exists('responseSuccessCreated')) {

    function responseSuccessCreated(string|array $body = [])
    {
        return responseSuccess($body, Response::HTTP_CREATED);
    }
}

if (!function_exists('responseError')) {

    function responseError(string $message = 'Error', $http = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $body = array_merge(['status_code' => $http, 'status_message' => Response::$statusTexts[$http]]);

        return responseJson(array_merge($body, ['status' => false, 'message' => $message]), $http);
    }
}

if (!function_exists('responseInternalServerError')) {

    function responseInternalServerError(string $message = 'Internal Server Error')
    {
        return responseError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

if (!function_exists('responseNotFound')) {

    function responseNotFound(string $message = 'Data tidak ada')
    {
        return responseError($message, Response::HTTP_NOT_FOUND);
    }
}

if (!function_exists('responseBadRequest')) {

    function responseBadRequest(string $message = 'Bad Request')
    {
        return responseError($message, Response::HTTP_BAD_REQUEST);
    }
}

if (!function_exists('responseUnprossableContent')) {

    function responseUnprossableContent(string $message = 'Unprocessable Content')
    {
        return responseError($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

if (!function_exists('responseUnauthorized')) {

    function responseUnauthorized(string $message = 'Unauthorized')
    {
        return responseError($message, Response::HTTP_UNAUTHORIZED);
    }
}

if (!function_exists('responseForbidden')) {

    function responseForbidden(string $message = 'Forbidden')
    {
        return responseError($message, Response::HTTP_FORBIDDEN);
    }
}

if (!function_exists('translatedFormat')) {

    function translatedFormat($date, $format = 'd F Y')
    {
        if ($date) {
            return parseDate($date)->translatedFormat($format);
        } else {
            return null;
        }
    }
}

if (!function_exists('parseDate')) {
    function parseDate($date)
    {
        if ($date) {
            return Carbon::parse($date);
        } else {
            return null;
        }
    }
}

if (!function_exists('removeKeysFromPagination')) {
    function removeKeysFromPagination($object, ?array $remove_array_keys = []): array
    {
        // default removed keys
        $default_removed_keys = [
            'from', 'links', 'first_page_url', 'last_page_url', 'options', 'to', 'last_page'
        ];

        // merge array
        $remove_array_keys = array_merge($remove_array_keys, $default_removed_keys);

        // convert to array
        $data = $object->toArray();

        return removeKeysFromArray($data, $remove_array_keys);
    }
}

if (!function_exists('removeKeysFromArray')) {
    function removeKeysFromArray(array $data, array $remove_array_keys): array
    {
        // remove key use foreach
        foreach ($remove_array_keys as $key) {
            unset($data[$key]);
        }

        return $data;
    }
}

if (!function_exists('validateDate')) {
    function validateDate($date, $format = 'd/m/Y')
    {
        $d = DateTime::createFromFormat('!' . $format, $date);

        $check = $d && $d->format($format) == $date;
        if ($check) {
            $new_date = formatingDate($date);

            return date('Y-m-d', strtotime($new_date));
        } else {
            return null;
        }
    }
}

if (!function_exists('formatingDate')) {
    function formatingDate($date): array|string
    {
        $array = [
            ' ', ')', '(', '/', ',', '&', '%', '`',
            '~', '?', '<', '>', '"', '[', ']', '{', '}', ':',
            '!', '@', '#', '$', '^', '*', '-', '_', '+', '=',
            `'\'`, '|', `'`, ';'
        ];
        return str_replace($array, '-', $date);
    }
}
