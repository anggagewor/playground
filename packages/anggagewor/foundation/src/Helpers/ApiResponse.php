<?php

namespace Anggagewor\Foundation\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function success(mixed $data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function error(string $message = 'Error', int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public function paginated(Paginator $paginator, string $message = 'Success'): JsonResponse
    {
        $pagination = [
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];

        if ($paginator instanceof LengthAwarePaginator) {
            $pagination['total'] = $paginator->total();
            $pagination['last_page'] = $paginator->lastPage();
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => $pagination,
        ]);
    }
}
