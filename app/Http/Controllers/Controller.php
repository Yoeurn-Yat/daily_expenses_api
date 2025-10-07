<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function jsonResponse($data, $status = 200, $message = null)
    {
        return response()->json([
            'data' => $data,
            'status' => $status,
            'message' => 'Success' ?? $message
        ], $status);
    }

    public function responsePaginate($data, $status = 200, $message = null)
    {
        return response()->json([
            'message' => 'Success' ?? $message,
            'status' => $status,
            'data' => $data->items(),
            'links' => [
                'first' => $data->url(1),
                'last' => $data->url($data->lastPage()),
                'prev' => $data->previousPageUrl(),
                'next' => $data->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $data->currentPage(),
                'from' => $data->firstItem(),
                'last_page' => $data->lastPage(),
                'path' => $data->path(),
                'per_page' => $data->perPage(),
                'to' => $data->lastItem(),
                'total' => $data->total()
            ]
        ], $status);

    }

    public function jsonError($message, $status = 400)
    {
        return response()->json([
            'message' => $message,
            'status' => $status
        ], $status);
    }
}
