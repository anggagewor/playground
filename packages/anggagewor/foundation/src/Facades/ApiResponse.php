<?php

namespace Anggagewor\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse success(mixed $data = null, string $message = 'Success', int $status = 200)
 * @method static \Illuminate\Http\JsonResponse error(string $message = 'Error', int $status = 400, mixed $errors = null)
 * @method static \Illuminate\Http\JsonResponse paginated(\Illuminate\Contracts\Pagination\Paginator $paginator, string $message = 'Success')
 */
class ApiResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api.response';
    }
}
