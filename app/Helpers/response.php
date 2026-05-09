<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'Success', $code = 200, $meta = null): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('rejectedResponse')) {
    function rejectedResponse($message = 'Rejected', $code = 409, $errors = null): JsonResponse
    {
        $response = [
            'status' => 'rejected',
            'message' => $message,
            'code' => $code,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'Something went wrong', $code = 500, $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'code' => $code,
        ];

        if ($errors !== null) {
            $response['data']['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}

/*
|--------------------------------------------------------------------------
| Shortcut Responses
|--------------------------------------------------------------------------
*/

if (!function_exists('successMessage')) {
    function successMessage($message = 'Success'): JsonResponse
    {
        return successResponse(null, $message, 200);
    }
}

if (!function_exists('errorMessage')) {
    function errorMessage($message = 'error'): JsonResponse
    {
        return errorResponse(null, $message, 400);
    }
}

if (!function_exists('createdResponse')) {
    function createdResponse($data = null, $message = 'Data created'): JsonResponse
    {
        return successResponse($data, $message, 201);
    }
}

if (!function_exists('updatedResponse')) {
    function updatedResponse($data = null, $message = 'Data updated'): JsonResponse
    {
        return successResponse($data, $message, 200);
    }
}

if (!function_exists('deletedResponse')) {
    function deletedResponse($message = 'Data deleted'): JsonResponse
    {
        return successResponse(null, $message, 200);
    }
}

if (!function_exists('notFoundResponse')) {
    function notFoundResponse($message = 'Data not found'): JsonResponse
    {
        return errorResponse($message, 404);
    }
}

if (!function_exists('validationErrorResponse')) {
    function validationErrorResponse($errors, $message = 'Validation error'): JsonResponse
    {
        return errorResponse($message, 422, $errors);
    }
}

if (!function_exists('unauthorizedResponse')) {
    function unauthorizedResponse($message = 'Unauthorized'): JsonResponse
    {
        return errorResponse($message, 401);
    }
}

if (!function_exists('forbiddenResponse')) {
    function forbiddenResponse($message = 'Forbidden'): JsonResponse
    {
        return errorResponse($message, 403);
    }
}

if (!function_exists('serverErrorResponse')) {
    function serverErrorResponse($message = 'Internal server error'): JsonResponse
    {
        return errorResponse($message, 500);
    }
}

/*
|--------------------------------------------------------------------------
| Pagination Response
|--------------------------------------------------------------------------
*/

if (!function_exists('paginatedResponse')) {
    function paginatedResponse($data, $message = 'Success'): JsonResponse
    {
        return successResponse(
            $data->items(),
            $message,
            200,
            [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        );
    }
}
