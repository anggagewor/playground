<?php

namespace Anggagewor\Foundation\Tests\Unit;

use Anggagewor\Foundation\Helpers\ApiResponse;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseTest extends TestCase
{
    protected ApiResponse $apiResponse;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiResponse = new ApiResponse;
    }

    public function test_success_response_returns_correct_json_structure()
    {
        $response = $this->apiResponse->success(['foo' => 'bar'], 'It works');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([
            'status' => 'success',
            'message' => 'It works',
            'data' => ['foo' => 'bar'],
        ], $response->getData(true));
    }

    public function test_error_response_returns_correct_json_structure()
    {
        $response = $this->apiResponse->error('Something went wrong', 422, ['field' => 'invalid']);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals([
            'status' => 'error',
            'message' => 'Something went wrong',
            'errors' => ['field' => 'invalid'],
        ], $response->getData(true));
    }

    public function test_paginated_response_returns_correct_json_structure()
    {
        $items = collect([['id' => 1], ['id' => 2]]);
        $paginator = new LengthAwarePaginator($items, 2, 10, 1);

        $response = $this->apiResponse->paginated($paginator);

        $data = $response->getData(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('pagination', $data);
        $this->assertEquals([
            'total' => 2,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 1,
        ], $data['pagination']);
    }
}
