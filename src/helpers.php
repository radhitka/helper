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

        return responseJson($body, $http);
    }
}

if (!function_exists('responseNotFound')) {

    function responseNotFound(string $message = 'Data tidak ada', $http = Response::HTTP_NOT_FOUND)
    {
        return responseJson(['status' => false, 'message' => $message], $http);
    }
}

if (!function_exists('responseError')) {

    function responseError(string $message = 'Error', $http = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return responseJson(['status' => false, 'message' => $message], $http);
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
