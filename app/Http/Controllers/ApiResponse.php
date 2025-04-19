<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * Class ApiResponse
 * @package App\Http\Controllers
 */
class ApiResponse
{
    /**
     * @param $data
     * @return Response
     */
    public function objectCreated($data)
    {
        return $this->responseJson($data, StatusCode::HTTP_CREATED);
    }

    /**
     * @param $resource
     * @return Response
     */
    public function resourceFound($resource)
    {
        return response($resource, StatusCode::HTTP_OK);
    }


    /**
     * @return Response
     */
    public function resourceNotfound()
    {
        return response(['error' => 'Not found'], StatusCode::HTTP_NOT_FOUND);
    }

    /**
     * @param $errors
     * @return Response
     */
    public function notAcceptable($errors)
    {
        return $this->responseJson($errors, StatusCode::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @param array $content
     * @param int $statusCode
     * @return Response
     */
    private function responseJson(array $content, $statusCode = StatusCode::HTTP_OK)
    {
        return response($content, $statusCode);
    }
}
